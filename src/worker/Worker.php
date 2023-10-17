<?php

namespace uzdevid\webhook\worker;

use uzdevid\webhook\models\Hook;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class Worker extends BaseObject implements JobInterface {
    public Hook $hook;
    public array $data;
    public string $method = 'POST';
    public AuthInterface $auth;

    public function __construct(Hook $hook, array $data) {
        $this->hook = $hook;
        $this->data = $data;

        $this->auth = AuthFactory::create($hook->auth['type'], $hook->auth['params']);
        parent::__construct();
    }

    public function execute($queue): void {

    }
}