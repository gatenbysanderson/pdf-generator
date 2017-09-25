<?php

namespace App\Contracts;

interface PdfConversion
{

    /**
     * Sets whether JavaScript should be enabled or disabled for this request.
     *
     * @param bool $option
     * @return PdfConversion
     * @throws RuntimeException
     */
    public function enableJavaScript(bool $option): self;

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @return PdfConversion
     * @throws RuntimeException
     */
    public function compile(array $files): self;

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws RuntimeException
     */
    public function get(): string;
}
