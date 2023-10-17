<?php

namespace uzdevid\webhook;

use Yii;
use yii\base\Component;
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

    public function call(string $name, array $data = []): void {
        $this->queue->push(new Dispatcher($name, $data, $this));
    }
}