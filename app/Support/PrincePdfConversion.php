<?php

namespace App\Support;

use App\Contracts\MetricsLogger;
use App\Contracts\PdfConversion;
use App\Exceptions\PdfCompileException;
use App\Libraries\Prince;
use RuntimeException;

class PrincePdfConversion implements PdfConversion
{
    /**
     * @var \App\Contracts\MetricsLogger
     */
    protected $metrics_logger;

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
     *
     * @param \App\Contracts\MetricsLogger $metrics_logger
     */
    public function __construct(MetricsLogger $metrics_logger)
    {
        $this->metrics_logger = $metrics_logger;
        $this->enabled = [
            'javascript' => false,
        ];
    }

    /**
     * Sets whether JavaScript should be enabled or disabled for this request.
     *
     * @param bool $option
     * @return \App\Contracts\PdfConversion
     */
    public function enableJavaScript(bool $option = true): PdfConversion
    {
        $this->enabled['javascript'] = $option;

        return $this;
    }

    /**
     * Compile the set of files into a PDF stream.
     *
     * @param array $files
     * @return \App\Contracts\PdfConversion
     * @throws \RuntimeException
     */
    public function compile(array $files): PdfConversion
    {
        if (empty($files)) {
            throw new RuntimeException('No files provided for conversion.');
        }

        $this->metrics_logger->start();

        $prince = new Prince('/usr/bin/prince');
        $prince->setPageMargin('45px');
        $prince->setCompress(false);
        $prince->setJavaScript($this->enabled['javascript']);
        $prince->setInsecure(true);

        ob_start();
        $conversion = $prince->convert_multiple_files_to_passthru($files);
        $this->compiled = ob_get_clean();

        if ($conversion !== true) {
            throw new PdfCompileException('Failed to compile the HTML file(s) into PDF format.');
        }

        $this->metrics_logger->end()->log('PDF created.');

        return $this;
    }

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws \RuntimeException
     */
    public function get(): string
    {
        return $this->getCompiledContent();
    }

    /**
     * Retrieve the PDF stream.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected function getCompiledContent(): string
    {
        if (empty($this->compiled)) {
            throw new RuntimeException('No files provided for conversion.');
        }

        return $this->compiled;
    }
}
