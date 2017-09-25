<?php

namespace App\Controllers\Api\V1;

use App\Support\HttpRequest;
use App\Support\JsonResponse;

class PdfController
{
    /**
     * @param \App\Support\HttpRequest $request
     */
    public function index(HttpRequest $request)
    {
        resolve(\App\Contracts\MetricsLogger::class)->log('Testing SQLite', 369);
        JsonResponse::ok($request->all());
    }

    /**
     * @param \App\Support\HttpRequest $request
     */
    public function store(HttpRequest $request)
    {
        JsonResponse::created(['name' => 'Ben']);
    }
}
