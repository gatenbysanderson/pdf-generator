<?php

namespace App\Controllers\Api\V1;

use App\Contracts\MetricsLogger;
use App\Support\HttpRequest;
use App\Support\JsonResponse;

class PdfController
{
    /**
     * @param \App\Support\HttpRequest $request
     */
    public function index(HttpRequest $request)
    {
        JsonResponse::ok($request->all());
    }

    /**
     * @param \App\Support\HttpRequest $request
     */
    public function store(HttpRequest $request)
    {
        $metrics_logger = resolve(MetricsLogger::class)->start();

        // TODO: Create the PDF.

        $metrics_logger->end()->log('PDF created.');

        JsonResponse::created($request->all());
    }
}
