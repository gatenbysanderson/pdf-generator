<?php

namespace App\Support;

class JsonResponse
{
    /**
     * JsonResponse constructor.
     */
    protected function __construct()
    {
        // Don't allow instantiation;
    }

    /**
     * @param array $payload
     */
    public static function ok(array $payload)
    {
        header('Content-Type: application/json; HTTP/1.1 200 OK');
        echo json_encode($payload);
        die;
    }

    /**
     * @param array $payload
     */
    public static function created(array $payload)
    {
        header('Content-Type: application/json; HTTP/1.1 201 Created');
        echo json_encode($payload);
        die;
    }
}
