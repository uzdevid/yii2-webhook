<?php

namespace uzdevid\webhook;

use uzdevid\webhook\models\Event;
use uzdevid\webhook\worker\Worker;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class Dispatcher extends BaseObject implements JobInterface {
    public string $event;
    public Payload $payload;
    public WebHook $webhook;
    public int $time;

    /**
     * @param string $event
     * @param Payload $payload
     * @param WebHook $webhook
     * @param int $time
     * @param array $config
     */
    public function __construct(string $event, Payload $payload, WebHook $webhook, int $time, array $config = []) {
        parent::__construct($config);
        $this->event = $event;
        $this->payload = $payload;
        $this->webhook = $webhook;
        $this->time = $time;
    }

    /**
     * @param $queue
     *
     * @return void
     */
    public function execute($queue): void {
        if ($this->webhook->delay === false) {
            return;
        }

        /** @var Event $event */
        $event = Event::findOne(['name' => $this->event]);

        if (is_null($event)) {
            Yii::warning('Event not found: ' . $this->event);
            return;
        }

        foreach ($event->hookEvents as $hookEvent) {
            $this->webhook->queue->delay($this->webhook->delay)->push(new Worker($hookEvent->hook, $event, $this));
        }
    }
}