<?php

namespace uzdevid\webhook\worker;

use yii\base\BaseObject;

abstract class Auth extends BaseObject {
    public array $headers = [];
    public array $queries = [];

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    protected function addHeader(string $name, string $value): void {
        $this->headers[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function removeHeader(string $name): void {
        unset($this->headers[$name]);
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    protected function addQuery(string $name, string $value): void {
        $this->queries[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function removeQuery(string $name): void {
        unset($this->queries[$name]);
    }

    /**
     * @return array
     */
    public function getQueries(): array {
        return $this->queries;
    }

    /**
     * @return void
     */
    abstract public function create(): void;
}