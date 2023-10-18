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
    public string $dbName = 'db';
    public string $mq;
    public Queue $queue;
    public array $attempts = [0, 60, 120];

    /**
     * @return void
     */
    public function init(): void {
        parent::init();
        $this->queue = Yii::$app->get($this->mq);
    }

    /**
     * @param string $name
     * @param Payload $payload
     *
     * @return void
     */
    public function call(string $name, Payload $payload): void {
        $this->queue->push(new Dispatcher($name, $payload, $this, time()));
    }

    /**
     * @return int|bool
     */
    public function getDelay(): int|bool {
        return $this->attempts[0] ?? false;
    }
}