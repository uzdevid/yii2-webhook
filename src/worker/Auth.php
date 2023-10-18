<?php

namespace uzdevid\webhook\worker;

use yii\base\BaseObject;

abstract class Auth extends BaseObject {
    public array $headers = [];
    public array $queries = [];

    protected function addHeader(string $name, string $value): void {
        $this->headers[$name] = $value;
    }

    protected function removeHeader(string $name): void {
        unset($this->headers[$name]);
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    protected function addQuery(string $name, string $value): void {
        $this->queries[$name] = $value;
    }

    protected function removeQuery(string $name): void {
        unset($this->queries[$name]);
    }

    public function getQueries(): array {
        return $this->queries;
    }

    abstract public function create(): void;
}