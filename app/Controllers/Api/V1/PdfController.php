<?php

namespace App\Controllers\Api\V1;

use App\Contracts\MetricsLogger;
use App\Contracts\PdfConversion;
use App\Exceptions\PdfCompileException;
use App\Support\HttpRequest;
use App\Support\JsonResponse;
use Exception;

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
        try {
            $metrics_logger = resolve(MetricsLogger::class)->start();
            $pdfConversion = resolve(PdfConversion::class);

            $files = $request->input('files');
            $files = is_array($files) ? $files : [$files];

            $pdf = $pdfConversion->enableJavaScript()->compile($files)->get();

            $metrics_logger->end()->log('PDF created.');

            JsonResponse::created(['pdf' => $pdf]);
        } catch (PdfCompileException $exception) {
            JsonResponse::badRequest('Could not compile PDF.');
        } catch (Exception $exception) {
            JsonResponse::badRequest('Could not generate PDF.');
        }
    }
}
