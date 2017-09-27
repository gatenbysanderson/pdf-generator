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
     * @param array $data
     * @return void
     */
    public static function ok(array $data = [])
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 200 OK');
        echo json_encode(['status' => 'success', 'data' => $data]);
        die;
    }

    /**
     * Return an HTTP 201 status.
     *
     * @param array $data
     * @return void
     */
    public static function created(array $data = [])
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 201 Created');
        echo json_encode(['status' => 'success', 'data' => $data]);
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
        header('Content-Type: application/json');
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['status' => 'error', 'message' => $message]);
        die;
    }

    /**
     * Return an HTTP 400 status.
     *
     * @param string $message
     * @return void
     */
    public static function notFound(string $message = 'Not Found')
    {
        header('Content-Type: application/json');
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['status' => 'error', 'message' => $message]);
        die;
    }
}
