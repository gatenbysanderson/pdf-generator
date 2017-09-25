<?php

namespace App\Support;

use App\Contracts\PdfConversion;
use App\Libraries\Prince;
use RuntimeException;
use Exception;

class PrincePdfConversion implements PdfConversion
{
    /**
     * Determines what PrinceXML features are enabled or disabled for the request.
     *
     * @var array
     */
    protected $enabled;

    /**
     * The compiled string returned by PrinceXML.
     *
     * @var string
     */
    protected $compiled;

    /**
     * PrincePdfConversion constructor.
     */
    public function __construct()
    {
        $this->enabled = [
            'javascript' => false,
        ];
    }

    /**
     * Sets whether JavaScript should be enabled or disabled for this request.
     *
     * @param bool $option
     * @return PdfConversion
     */
    public function enableJavaScript(bool $option): PdfConversion
    {
        $this->enabled['javascript'] = $option;

        return $this;
    }

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @return PdfConversion
     * @throws RuntimeException
     */
    public function compile(array $files): PdfConversion
    {
        if (empty($files)) {
            throw new RuntimeException('No files provided for conversion.');
        }

        $prince = new Prince('/usr/bin/prince');

        $prince->setPageMargin('45px');

        $prince->setCompress(false);

        $compiled = [];

        foreach ($files as $file) {
            if (preg_match('/\.blade\.php$/', basename($file))) {
                $compiled[] = $this->compileBladeView($file);
            } else {
                ob_start();

                require_once $file;

                $compiled[] = ob_get_clean();
            }
        }

        ob_start();

        $conversion = $prince->convert_string_to_passthru(implode($compiled));

        if ($conversion !== true) {
            throw new RuntimeException('Failed to compile the HTML file(s) into PDF format.');
        }

        $this->compiled = ob_get_clean();

        return $this;
    }

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws RuntimeException
     */
    public function get(): string
    {
        return $this->getCompiledContent();
    }

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws RuntimeException
     */
    protected function getCompiledContent(): string
    {
        if (empty($this->compiled)) {
            throw new RuntimeException('No files provided for conversion.');
        }

        return $this->compiled;
    }

    /**
     * Compile Blade files into raw PHP.
     *
     * @param string $file
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function compileBladeView(string $file, array $data = []): string
    {
        $find = '/^([a-zA-Z0-9\-_]+)([\.a-zA-Z]+)$/';
        $replace = '$1';

        $path = $this->path . $this->delimiter . preg_replace($find, $replace, basename($file));

        try {
            $compiled = view($path, $data)->render();
        } catch (Exception $e) {
            throw $e;
        }

        return $compiled;
    }
}
