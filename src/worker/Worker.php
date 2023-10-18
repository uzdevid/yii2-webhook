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
use yii\helpers\Console;
use yii\queue\JobInterface;

class Worker extends BaseObject implements JobInterface {
    public Hook $hook;
    public Event $event;
    public Dispatcher $dispatcher;
    public string $method = 'POST';
    public Auth $auth;
    public Attempt|null $lastAttempt = null;
    public Attempt $currentAttempt;

    protected array $headers = [
        'Content-Type' => 'application/json',
        'User-Agent' => 'uzdevid/yii2-webhook',
    ];

    protected array $queries = [];

    public function __construct(Hook $hook, Event $event, Dispatcher $dispatcher, Attempt|null $lastAttempt = null) {
        $this->hook = $hook;
        $this->event = $event;
        $this->dispatcher = $dispatcher;
        $this->lastAttempt = $lastAttempt;

        $this->currentAttempt = new Attempt();
        $this->currentAttempt->attempt = 1;

        if (!is_null($this->lastAttempt)) {
            $this->currentAttempt->attempt = $this->lastAttempt->attempt + 1;
        }

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

        $this->currentAttempt->hook_id = $this->hook->id;
        $this->currentAttempt->event = $this->event->name;
        $this->currentAttempt->payload = $this->dispatcher->data;
        $this->currentAttempt->status = $response->getStatusCode();
        $this->currentAttempt->response = base64_encode($response->getBody()->getContents());
        $this->currentAttempt->create_time = date('Y-m-d H:i:s');
        $this->currentAttempt->save();

        if ($this->currentAttempt->status != 200 && $this->notLastAttempt()) {
            $this->dispatcher->webhook->queue
                ->delay($this->getDelay())
                ->push(new Worker($this->hook, $this->event, $this->dispatcher, $this->currentAttempt));
        }
    }

    private function notLastAttempt(): bool {
        return $this->currentAttempt->attempt < count($this->dispatcher->webhook->attempts);
    }

    private function getDelay(): int {
        return $this->dispatcher->webhook->attempts[$this->currentAttempt->attempt];
    }
}