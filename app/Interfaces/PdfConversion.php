<?php

namespace App\Interfaces;

interface PdfConversion
{

    /**
     * Sets whether JavaScript should be enabled or disabled for this request.
     *
     * @param bool $option
     * @return $this
     * @throws RuntimeException
     */
    public function enableJavaScript($option);

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @param array $data
     * @return $this
     * @throws RuntimeException
     */
    public function compile(array $files, array $data = []);

    /**
     * Retrieve the PDF stream.
     *
     * @return bool
     * @throws RuntimeException
     */
    public function get();
}
