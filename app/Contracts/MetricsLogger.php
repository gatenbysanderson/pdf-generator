<?php

namespace App\Contracts;

interface MetricsLogger
{
    /**
     * @param string $message
     * @param int $time_in_milliseconds
     * @return bool
     */
    public function log(string $message, int $time_in_milliseconds): bool;
}
