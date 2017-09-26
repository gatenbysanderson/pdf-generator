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
            $pdf_conversion = resolve(PdfConversion::class);

            $enable_java_script = array_key_exists('javascript', $request->input('options', []))
                ? (bool)$request->input('options')['javascript']
                : false;
            $files = $request->files()['sources']['tmp_name'];
            $files = is_array($files) ? $files : [$files];
            $files = array_map(function ($file) {
                return file_get_contents($file);
            }, $files);

            $pdf = $pdf_conversion->enableJavaScript($enable_java_script)->compile($files)->get();

            $metrics_logger->end()->log('PDF created.');

            JsonResponse::created(['type' => 'application/pdf', 'content' => base64_encode($pdf)]);
        } catch (PdfNoFilesException $exception) {
            JsonResponse::badRequest('No files provided.');
        } catch (PdfCompileException $exception) {
            JsonResponse::badRequest('Could not compile PDF.');
        } catch (Exception $exception) {
            JsonResponse::badRequest('Could not generate PDF.');
        }
    }
}
