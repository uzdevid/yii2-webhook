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
        /** @var Event $event */
        $event = Event::findOne(['name' => $this->event]);

        foreach ($event->hookEvents as $hookEvent) {
            $this->webhook->queue->delay($this->webhook->defaultDelay)->push(new Worker($hookEvent->hook, $this->data));
        }
    }
}