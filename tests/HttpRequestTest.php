<?php

use App\Support\HttpRequest;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Constraint\IsType;

class HttpRequestTest extends TestCase
{
    public function test_constructor_returns_instance_with_no_request_data()
    {
        $request = new HttpRequest();

        $this->assertInstanceOf(HttpRequest::class, $request);
    }

    public function test_has_method_returns_true_when_array_key_exists()
    {
        $_REQUEST['foo'] = 'bar';

        $request = new HttpRequest();

        $has = $request->has('foo');

        $this->assertTrue($has);
    }

    public function test_has_method_returns_false_when_array_key_does_not_exist()
    {
        $request = new HttpRequest();

        $has = $request->has('foo');

        $this->assertFalse($has);
    }

    public function test_input_method_returns_null_when_array_key_does_not_exist()
    {
        $request = new HttpRequest();

        $input = $request->input('foo');

        $this->assertNull($input);
    }

    public function test_input_method_returns_string_when_array_key_exists()
    {
        $_REQUEST['foo'] = 'bar';

        $request = new HttpRequest();

        $input = $request->input('foo');

        $this->assertInternalType(IsType::TYPE_STRING, $input);
    }

    public function test_all_method_returns_empty_array_with_no_request_data()
    {
        $request = new HttpRequest();

        $all = $request->all();

        $this->assertEquals([], $all);
    }

    public function test_all_method_returns_correct_array_with_request_data()
    {
        $_REQUEST['foo'] = 'bar';

        $request = new HttpRequest();

        $all = $request->all();

        $this->assertEquals(['foo' => 'bar'], $all);
    }

    public function test_has_file_method_returns_true_with_file_data()
    {
        $_FILES['foo'] = 'bar';

        $request = new HttpRequest();

        $has_file = $request->hasFile('foo');

        $this->assertTrue($has_file);
    }

    public function test_has_file_method_returns_false_with_no_file_data()
    {
        $request = new HttpRequest();

        $has_file = $request->hasFile('foo');

        $this->assertFalse($has_file);
    }

    public function test_files_method_returns_specific_file_data_with_valid_key()
    {
        $_FILES['foo'] = ['bar'];

        $request = new HttpRequest();

        $files = $request->files('foo');

        $this->assertEquals(['bar'], $files);
    }

    public function test_files_method_returns_null_with_invalid_key()
    {
        $request = new HttpRequest();

        $files = $request->files('foo');

        $this->assertNull($files);
    }

    public function test_files_method_returns_empty_array_with_no_key()
    {
        $request = new HttpRequest();

        $files = $request->files();

        $this->assertEquals([], $files);
    }

    public function test_files_method_returns_all_file_data_with_no_key()
    {
        $_FILES['foo'] = ['bar'];

        $request = new HttpRequest();

        $files = $request->files();

        $this->assertEquals(['foo' => ['bar']], $files);
    }
}
