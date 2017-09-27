<?php

namespace App\Contracts;

interface MetricsLogger
{
    /**
     * @param string $message
     * @return bool
     */
    public function log(string $message): bool;

    /**
     * Set the start time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function start(): self;

    /**
     * Set the end time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function end(): self;
}
