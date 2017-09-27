<?php

use App\Contracts\MetricsLogger;
use App\Support\PrincePdfConversion;
use PHPUnit\Framework\TestCase;

class PrincePdfConversionTest extends TestCase
{
    public function test_constructor_fails_when_true_passed()
    {
        $this->expectException(\TypeError::class);

        $prince_pdf_conversion = new PrincePdfConversion(true);
    }

    public function test_constructor_works_when_passed_metrics_logger()
    {
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }

    public function test_enable_java_script_returns_instance_of_self()
    {
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->enableJavaScript();

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }

    public function test_compile_fails_when_empty_array_passed()
    {
        $this->expectException(\Exception::class);

        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile([]);
    }

    public function test_compile_works_when_array_of_1_string_passed()
    {
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile(['Hello World!']);

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }

    public function test_compile_works_when_array_of_3_string_passed()
    {
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile(['Hello World!', 'Foo', 'Bar']);

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }
}

class MetricsLoggerStub implements MetricsLogger
{

    /**
     * @param string $message
     * @return bool
     */
    public function log(string $message): bool
    {
        return true;
    }

    /**
     * Set the start time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function start(): MetricsLogger
    {
        return $this;
    }

    /**
     * Set the end time of the log.
     *
     * @return \App\Contracts\MetricsLogger
     */
    public function end(): MetricsLogger
    {
        return $this;
    }
}
