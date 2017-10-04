<?php

namespace Tests;

use App\Contracts\MetricsLogger;
use App\Support\PrincePdfConversion;
use PHPUnit\Framework\Constraint\IsType;

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

    public function test_compile_works_when_array_of_1_file_path_string_passed()
    {
        createFile('page1.html', '<h1>Hello World!</h1>');
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile([storagePath('tests/page1.html')]);

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }

    public function test_compile_works_when_array_of_3_file_path_strings_passed()
    {
        createFile('page1.html', '<h1>Hello World!</h1>');
        createFile('page2.html', '<h1>Hello World!</h1>');
        createFile('page3.html', '<h1>Hello World!</h1>');
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile([
            storagePath('tests/page1.html'),
            storagePath('tests/page2.html'),
            storagePath('tests/page3.html')
        ]);

        $this->assertInstanceOf(PrincePdfConversion::class, $prince_pdf_conversion);
    }

    public function test_get_fails_when_not_compiled()
    {
        $this->expectException(\Exception::class);

        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->get();
    }

    public function test_get_works_when_array_of_1_file_path_string_compiled()
    {
        createFile('page1.html', '<h1>Hello World!</h1>');
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile([storagePath('tests/page1.html')]);
        $pdf = $prince_pdf_conversion->get();

        $this->assertInternalType(IsType::TYPE_STRING, $pdf);
    }

    public function test_get_works_when_array_of_3_file_path_strings_compiled()
    {
        createFile('page1.html', '<h1>Hello World!</h1>');
        createFile('page2.html', '<h1>Hello World!</h1>');
        createFile('page3.html', '<h1>Hello World!</h1>');
        $metrics_logger = new MetricsLoggerStub();
        $prince_pdf_conversion = new PrincePdfConversion($metrics_logger);
        $prince_pdf_conversion = $prince_pdf_conversion->compile([
            storagePath('tests/page1.html'),
            storagePath('tests/page2.html'),
            storagePath('tests/page3.html')
        ]);
        $pdf = $prince_pdf_conversion->get();

        $this->assertInternalType(IsType::TYPE_STRING, $pdf);
    }
}

function createFile(string $file_name, string $contents = ''): bool
{
    $file_path = storagePath('tests/' . trim($file_name, '/'));

    return (bool)file_put_contents($file_path, $contents);
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
