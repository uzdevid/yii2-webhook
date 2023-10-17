<?php

namespace uzdevid\webhook\worker;

use uzdevid\webhook\models\Attempt;
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
        $attempt = new Attempt();
        $attempt->hook_id = $this->hook->id;
        $attempt->event = 'test';
        $attempt->payload = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        $attempt->status = 'pending';
        $attempt->response = '';
        $attempt->create_time = date('Y-m-d H:i:s');
        $attempt->save();
    }
}