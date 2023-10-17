<?php

namespace uzdevid\webhook\worker;

class Worker {
    public string $url;
    public string $method = 'POST';
    public AuthInterface $auth;
}