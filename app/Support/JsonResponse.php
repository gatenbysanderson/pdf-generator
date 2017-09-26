<?php

namespace App\Support;

class JsonResponse
{
    /**
     * JsonResponse constructor.
     */
    protected function __construct()
    {
        // Don't allow instantiation
    }

    /**
     * Return an HTTP 200 status.
     *
     * @param array $payload
     * @return void
     */
    public static function ok(array $payload = [])
    {
        header('Content-Type: application/json; HTTP/1.1 200 OK');
        echo json_encode($payload);
        die;
    }

    /**
     * Return an HTTP 201 status.
     *
     * @param array $payload
     * @return void
     */
    public static function created(array $payload = [])
    {
        header('Content-Type: application/json; HTTP/1.1 201 Created');
        echo json_encode($payload);
        die;
    }

    /**
     * Return an HTTP 400 status.
     *
     * @param string $message
     * @return void
     */
    public static function badRequest(string $message = 'Bad Request')
    {
        header('Content-Type: application/json; HTTP/1.1 400 Bad Request');
        echo json_encode($message);
        die;
    }
}
