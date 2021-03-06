<?php

namespace App\Support;

use App\Contracts\MetricsLogger;
use RuntimeException;
use SQLite3;

class SqliteMetricsLogger implements MetricsLogger
{
    /**
     * Used to get the microtime as a float.
     */
    const MICROTIME_AS_FLOAT = true;

    /**
     * @var \SQLite3
     */
    protected $db;

    /**
     * @var int
     */
    protected $start_time_in_milliseconds;

    /**
     * @var int
     */
    protected $end_time_in_milliseconds;

    /**
     * SqliteMetricsLogger constructor.
     */
    public function __construct()
    {
        $this->db = new SQLite3(basePath('database/db.sqlite'));
        $this->db->exec('CREATE TABLE IF NOT EXISTS logs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message STRING NOT NULL, time_in_milliseconds INTEGER NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)');
    }

    /**
     * Set the message for the log.
     *
     * @param string $message
     * @return bool
     */
    public function log(string $message): bool
    {
        $statement = $this->db->prepare('INSERT INTO logs (message, time_in_milliseconds) VALUES (:message, :time_in_milliseconds)');
        $statement->bindValue(':message', $message, SQLITE3_TEXT);
        $statement->bindValue(':time_in_milliseconds', $this->executionTimeInMilliseconds(), SQLITE3_INTEGER);
        $statement->execute();

        return true;
    }

    /**
     * Set the start time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function start(): MetricsLogger
    {
        $this->start_time_in_milliseconds = $this->microtimeInMilliseconds();

        return $this;
    }

    /**
     * Set the end time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function end(): MetricsLogger
    {
        $this->end_time_in_milliseconds = $this->microtimeInMilliseconds();

        return $this;
    }

    /**
     * Return the total execution time between the start and end.
     *
     * @return int
     * @throws \RuntimeException
     */
    protected function executionTimeInMilliseconds(): int
    {
        if (! isset($this->start_time_in_milliseconds)) {
            throw new RuntimeException('Start time has not been set.');
        }

        if (! isset($this->end_time_in_milliseconds)) {
            throw new RuntimeException('End time has not been set.');
        }

        return $this->end_time_in_milliseconds - $this->start_time_in_milliseconds;
    }

    /**
     * @return int
     */
    protected function microtimeInMilliseconds(): int
    {
        return (int)(microtime(static::MICROTIME_AS_FLOAT) * 1000);
    }
}
