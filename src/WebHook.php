<?php

namespace uzdevid\webhook;

use Yii;
use yii\base\Component;
use yii\queue\redis\Queue;

/**
 * Class WebHook
 *
 * @property int|false $delay
 */
class WebHook extends Component {
    public string $mq;
    public Queue $queue;
    public array $attempts = [0, 60, 120];

    public function init(): void {
        parent::init();
        $this->queue = Yii::$app->get($this->mq);
    }

    public function call(string $name, array $data = []): void {
        $this->queue->push(new Dispatcher($name, $data, $this));
    }

    public function getDelay(): int|false {
        return $this->attempts[0] ?? false;
    }
}