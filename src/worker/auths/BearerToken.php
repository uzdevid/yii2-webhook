<?php

namespace uzdevid\webhook\worker\auths;

use uzdevid\webhook\worker\Auth;

class BearerToken extends Auth {
    public string $token;

    /**
     * @return void
     */
    public function create(): void {
        $this->addHeader('Authorization', 'Bearer ' . $this->token);
    }
}