<?php

namespace uzdevid\webhook;

use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;

class Payload extends BaseObject implements Arrayable {
    use ArrayableTrait;

    public array $event = [];
    public int $attempt;
    public array $data;

    public function __construct(array $data, array $config = []) {
        $this->data = $data;
        parent::__construct($config);
    }
}