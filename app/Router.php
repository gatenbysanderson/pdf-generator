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
        $uriParts = $this->getUriParts();
        var_dump($this->request, $uriParts);
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
}
