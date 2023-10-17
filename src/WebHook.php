<?php

namespace uzdevid\webhook;

use Yii;
use yii\base\Component;
use yii\base\Event;
use yii\queue\redis\Queue;

class WebHook extends Component {
    public string $mq;
    public Queue $queue;
    public int $maxAttempts = 3;
    public array $delays = [60, 120, 180];
    public int $defaultDelay = 0;

    public function init(): void {
        parent::init();
        $this->queue = Yii::$app->get($this->mq);
    }

    public function trigger($name, Event $event = null): void {
        parent::trigger($name, $event);
        $this->queue->push(new Dispatcher($name, $event->data, $this));
    }
}