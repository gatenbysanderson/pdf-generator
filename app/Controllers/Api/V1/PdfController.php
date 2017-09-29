<?php

namespace App\Controllers\Api\V1;

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
            // Get the PDF Conversion concrete implementation.
            $pdf_conversion = resolve(PdfConversion::class);

            // Get the posted options or default to an empty array.
            $options = $request->input('options', []);

            // Get the enable JavaScript option.
            $enable_javascript = array_key_exists('javascript', $options)
                ? (bool)$request->input('options')['javascript']
                : false;

            // Get the files from the request.
            $files = $request->files('sources');

            // Throw an exception if no files where posted.
            if ($files === null) {
                throw new PdfNoFilesException('No source files provided.');
            }

            // Convert the files into an array of their contents as strings.
            $files = $files['tmp_name'];
            $files = is_array($files) ? $files : [$files];

            // Get the compiled string of the generated PDF.
            $pdf = $pdf_conversion->enableJavaScript($enable_javascript)->compile($files)->get();

            JsonResponse::created([
                'type' => 'application/pdf',
                'encoding' => 'base64',
                'content' => base64_encode($pdf),
            ]);
        } catch (PdfNoFilesException $exception) {
            JsonResponse::badRequest('No files provided.');
        } catch (PdfCompileException $exception) {
            JsonResponse::badRequest('Could not compile PDF.');
        } catch (Exception $exception) {
            JsonResponse::badRequest('Could not generate PDF.');
        }
    }
}
