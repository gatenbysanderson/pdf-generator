<?php

namespace App\Controllers\Api\V1;

use App\Contracts\MetricsLogger;
use App\Contracts\PdfConversion;
use App\Exceptions\PdfCompileException;
use App\Exceptions\PdfNoFilesException;
use App\Support\HttpRequest;
use App\Support\JsonResponse;
use Exception;

class PdfController
{
    /**
     * @param \App\Support\HttpRequest $request
     */
    public function store(HttpRequest $request)
    {
        try {
            $metrics_logger = resolve(MetricsLogger::class)->start();
            $pdfConversion = resolve(PdfConversion::class);

            $files = $request->files()['sources']['tmp_name'];
            $files = array_map(function ($file) {
                return file_get_contents($file);
            }, $files);

            $pdf = $pdfConversion->enableJavaScript()->compile($files)->get();

            $metrics_logger->end()->log('PDF created.');

            JsonResponse::created(['type' => 'application/pdf', 'content' => utf8_encode($pdf)]);
        } catch (PdfNoFilesException $exception) {
            JsonResponse::badRequest('No files provided.');
        } catch (PdfCompileException $exception) {
            JsonResponse::badRequest('Could not compile PDF.');
        } catch (Exception $exception) {
            JsonResponse::badRequest('Could not generate PDF.');
        }
    }
}
