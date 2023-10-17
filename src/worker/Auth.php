<?php

namespace uzdevid\webhook\worker;

use yii\base\BaseObject;

class Auth extends BaseObject {
    public array $headers = [];
    public array $queries = [];

    protected function addHeader(string $name, string $value): void {
        $this->headers[$name] = $value;
    }

    protected function removeHeader(string $name): void {
        unset($this->headers[$name]);
    }

    protected function addQuery(string $name, string $value): void {
        $this->queries[$name] = $value;
    }

    protected function removeQuery(string $name): void {
        unset($this->queries[$name]);
    }
}