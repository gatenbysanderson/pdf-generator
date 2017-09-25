<?php

namespace App\Support;

use App\Contracts\MetricsLogger;
use SQLite3;

class SqliteMetricsLogger implements MetricsLogger
{
    /**
     * @var \SQLite3
     */
    protected $db;

    /**
     * SqliteMetricsLogger constructor.
     */
    public function __construct()
    {
        $this->db = new SQLite3(basePath('database/db.sqlite'));
        $this->db->exec('CREATE TABLE logs (id INTEGER PRIMARY KEY AUTOINCREMENT, message STRING, time_in_milliseconds INTEGER)');
    }

    /**
     * @param string $message
     * @param int $time_in_milliseconds
     * @return bool
     */
    public function log(string $message, int $time_in_milliseconds): bool
    {
        $statement = $this->db->prepare('INSERT INTO logs (message, time_in_milliseconds) VALUES (:message, :time_in_milliseconds)');
        $statement->bindValue(':message', $message, SQLITE3_TEXT);
        $statement->bindValue(':time_in_milliseconds', $time_in_milliseconds, SQLITE3_INTEGER);
        $statement->execute();

        return true;
    }
}
