<?php

namespace uzdevid\webhook;

class WebHook extends Component {
    public string $queue;
    public int $maxAttempts = 3;
    public array $delays = [60, 120, 180];
    public int $defaultDelay = 0;
}