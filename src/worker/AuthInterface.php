<?php

namespace uzdevid\webhook\worker;

interface AuthInterface {
    public function create(): void;
}