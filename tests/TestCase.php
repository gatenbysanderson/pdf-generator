<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
        foreach (glob(storagePath('tests/*.html')) as $test_file_path) {
            unlink($test_file_path);
        }
    }
}
