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
        $controller_class = $this->getControllerClass();

        if (class_exists($controller_class)) {
            $controller = new $controller_class();

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $controller->index($this->request);
                    return;
                case 'POST';
                    $controller->store($this->request);
                    return;
            }
        }

        $this->throwPageNotFoundException();
    }

    /**
     * Get the URI without the query string at the end.
     *
     * @return array
     */
    protected function getUriParts(): array
    {
        // Get the uri and append a question mark in case there isn't one.
        $request_uri = $_SERVER['REQUEST_URI'] . '?';

        // Remove everything after the first question mark.
        $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));

        // Only allow alphabetic characters and hyphens.
        $request_uri = preg_replace('/[^a-zA-Z0-9\-\/]/', '', $request_uri);

        // Trim any forward slashes.
        $request_uri = trim($request_uri, '/');

        // Explode the result on forward slashes to get the segments.
        $request_uri_parts = explode('/', $request_uri);

        return $request_uri_parts;
    }

    /**
     * @throws \Exception
     */
    protected function throwPageNotFoundException()
    {
        header('HTTP/1.1 404 Not Found');
        throw new \Exception('Page not found.', 404);
    }

    /**
     * @return string
     */
    protected function getControllerClass(): string
    {
        $controller_class = '\\App\\Controllers';

        foreach ($this->getUriParts() as $uri_part) {
            $controller_class .= '\\' . ucfirst(strtolower($uri_part));
        }

        $controller_class .= 'Controller';

        return $controller_class;
    }
}
