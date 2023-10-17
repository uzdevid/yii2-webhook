<?php

namespace uzdevid\webhook\worker\auths;

use uzdevid\webhook\worker\AuthInterface;
use uzdevid\webhook\worker\Auth;

class Basic extends Auth implements AuthInterface {
    public string $login;
    public string $password;

    public function create(): void {
        $this->addHeader('Authorization', 'Basic ' . base64_encode($this->login . ':' . $this->password));
    }
}