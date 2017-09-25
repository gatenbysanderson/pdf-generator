<?php

namespace App\Controllers\Api\V1;

use App\Contracts\MetricsLogger;
use App\Contracts\PdfConversion;
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
        $pdfConversion = resolve(PdfConversion::class);

        $files = $request->input('files');
        $files = is_array($files) ? $files : [$files];

        try {
            $pdf = $pdfConversion->enableJavaScript()->compile($files)->get();
        } catch (\RuntimeException $exception) {
            JsonResponse::badRequest('Could not generate PDF.');
        }

        $metrics_logger->end()->log('PDF created.');

        JsonResponse::created(['pdf' => $pdf]);
    }
}
