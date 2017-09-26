<?php

namespace App\Contracts;

interface PdfConversion
{
    /**
     * PdfConversion constructor.
     *
     * @param \App\Contracts\MetricsLogger $metrics_logger
     */
    public function __construct(MetricsLogger $metrics_logger);

    /**
     * Sets whether JavaScript should be enabled or disabled for this request.
     *
     * @param bool $option
     * @return PdfConversion
     * @throws \RuntimeException
     */
    public function enableJavaScript(bool $option = true): self;

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @return PdfConversion
     * @throws \RuntimeException
     */
    public function compile(array $files): self;

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws \RuntimeException
     */
    public function get(): string;
}
