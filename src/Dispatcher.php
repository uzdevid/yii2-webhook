<?php

namespace uzdevid\webhook;

use uzdevid\webhook\models\Event;
use uzdevid\webhook\worker\Worker;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class Dispatcher extends BaseObject implements JobInterface {
    public string $event;
    public array $data;
    public WebHook $webhook;

    public function __construct(string $event, array $data, WebHook $webhook, array $config = []) {
        parent::__construct($config);
        $this->event = $event;
        $this->data = $data;
        $this->webhook = $webhook;
    }

    public function execute($queue): void {
        if ($this->webhook->delay === false) {
            return;
        }

        /** @var Event $event */
        $event = Event::findOne(['name' => $this->event]);

        $queue = $this->webhook->delay === 0 ? $this->webhook->queue : $this->webhook->queue->delay($this->webhook->delay);
        
        foreach ($event->hookEvents as $hookEvent) {
            $queue->push(new Worker($hookEvent->hook, $event, $this));
        }
    }
}