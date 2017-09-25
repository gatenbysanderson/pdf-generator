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
        var_dump($this->request);
    }
}
