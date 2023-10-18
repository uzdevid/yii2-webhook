<?php

namespace uzdevid\webhook\worker\auths;

use uzdevid\webhook\worker\Auth;

class NoAuth extends Auth {
    /**
     * @return void
     */
    public function create(): void {
        // do nothing
    }
}