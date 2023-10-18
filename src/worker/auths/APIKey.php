<?php

namespace uzdevid\webhook\worker\auths;

use uzdevid\webhook\worker\Auth;
use uzdevid\webhook\worker\AuthInterface;

class APIKey extends Auth {
    public string $key;
    public string $value;

    /**
     * @return void
     */
    public function create(): void {
        $this->addQuery($this->key, $this->value);
    }
}