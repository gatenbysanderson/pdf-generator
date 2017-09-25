<?php

namespace App;

use App\Support\HttpRequest;

class Router
{
    /**
     * @var \App\Support\HttpRequest
     */
    protected $request;

    /**
     * Router constructor.
     *
     * @param \App\Support\HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function handle()
    {
        switch ($this->getUriSegment(0)) {
            case 'api':
                echo 'API ACCESSED';
                break;
            default:
                $this->throwPageNotFoundException();
                break;
        }
    }

    /**
     * Get the URI without the query string at the end.
     *
     * @return array
     */
    protected function getUriParts(): array
    {
        $request_uri = $_SERVER['REQUEST_URI'] . '?';
        $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
        $request_uri = trim($request_uri, '/');

        return explode('/', $request_uri);
    }

    /**
     * @param int $index
     * @return mixed|null
     */
    protected function getUriSegment(int $index)
    {
        $uri_parts = $this->getUriParts();

        if (array_key_exists($index, $uri_parts)) {
            return $uri_parts[$index];
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    protected function throwPageNotFoundException()
    {
        header('HTTP/1.1 404 Not Found');
        throw new \Exception('Page not found.', 404);
    }
}
