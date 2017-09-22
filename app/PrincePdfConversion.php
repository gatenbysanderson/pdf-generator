<?php

namespace App;

/* Libraries */
    use App\Libraries\Prince;

/* Interfaces */
    use App\Interfaces\PdfConversion;

/* Exceptions */
    use RuntimeException;
    use Exception;

class PrincePdfConversion implements PdfConversion
{

    /**
     * Determines the file at the destination can be overwritten.
     *
     * @var int
     */
    const OVERWRITE_OK = 1;

    /**
     * Determines the file at the destination cannot be overwritten.
     *
     * @var int
     */
    const OVERWRITE_NOT_ALLOWED = 2;

    /**
     * Determines what PrinceXML features are enabled or disabled for the request.
     *
     * @var array
     */
    private $enabled;

    /**
     * The compiled string returned by PrinceXML.
     *
     * @var string
     */
    private $compiled;

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
     * @return $this
     * @throws RuntimeException
     */
    public function enableJavaScript($option)
    {
        if (! is_bool($option)) {
            throw new RuntimeException('Passed value must be a boolean.');
        }

        $this->enabled['javascript'] = $option;

        return $this;
    }

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @param array $data
     * @return $this
     * @throws RuntimeException
     */
    public function compile(array $files, array $data = [])
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
                $compiled[] = $this->compileBladeView($file, $data);
            } else {
                ob_start();

                require_once($file);

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
    public function get()
    {
        return $this->getCompiledContent();
    }

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws RuntimeException
     */
    private function getCompiledContent()
    {
        if (empty($this->compiled)) {
            throw new RuntimeException('No files provided for conversion.');
        }

        return $this->compiled;
    }

    /**
     * Compile Blade files into raw PHP.
     *
     * @param $file
     * @param array $data
     * @return string
     * @throws Exception
     */
    private function compileBladeView($file, array $data = [])
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
