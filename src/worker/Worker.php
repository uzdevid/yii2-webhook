<?php

namespace uzdevid\webhook\worker;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use uzdevid\webhook\Dispatcher;
use uzdevid\webhook\models\Attempt;
use uzdevid\webhook\models\Event;
use uzdevid\webhook\models\Hook;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class Worker extends BaseObject implements JobInterface {
    public Hook $hook;
    public Event $event;
    public Dispatcher $dispatcher;
    public string $method = 'POST';
    public Auth $auth;
    public int $attempt;

    protected array $headers = [
        'Content-Type' => 'application/json',
        'User-Agent' => 'uzdevid/yii2-webhook',
    ];

    protected array $queries = [];

    public function __construct(Hook $hook, Event $event, Dispatcher $dispatcher, int $attempt = 1) {
        $this->hook = $hook;
        $this->event = $event;
        $this->dispatcher = $dispatcher;
        $this->attempt = $attempt;

        $this->auth = AuthFactory::create($hook->auth['type'], $hook->auth['params']);
        parent::__construct();
    }

    /**
     * @throws GuzzleException
     */
    public function execute($queue): void {
        $client = new Client();

        $this->auth->create();

        try {
            $response = $client->request($this->method, $this->hook->url, [
                'query' => array_merge($this->queries, $this->auth->getQueries()),
                'headers' => array_merge($this->headers, $this->auth->getHeaders()),
                'body' => json_encode($this->dispatcher->data, JSON_UNESCAPED_UNICODE),
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        $attempt = new Attempt();
        $attempt->hook_id = $this->hook->id;
        $attempt->attempt = $this->attempt;
        $attempt->event = $this->event->name;
        $attempt->payload = $this->dispatcher->data;
        $attempt->status = $response->getStatusCode();
        $attempt->response = base64_encode($response->getBody()->getContents());
        $attempt->create_time = date('Y-m-d H:i:s');
        $attempt->save();

        if ($attempt->status != 200 && $this->notLastAttempt()) {
            $this->dispatcher->webhook->queue->delay($this->getDelay())->push(new Worker($this->hook, $this->event, $this->dispatcher, $this->attempt + 1));
        }
    }

    private function notLastAttempt(): bool {
        return $this->attempt < count($this->dispatcher->webhook->attempts);
    }

    private function getDelay(): int {
        return $this->dispatcher->webhook->attempts[$this->attempt - 1];
    }
}