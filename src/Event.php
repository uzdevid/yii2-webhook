<?php

namespace uzdevid\webhook;

class Event extends \yii\base\Event {
    public array $data = [];

    public function __construct(array $data, array $config = []) {
        $this->data = $data;
        parent::__construct($config);
    }
}