<?php

use App\Support\HttpRequest;
use PHPUnit\Framework\TestCase;

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

        $has_foo = $request->has('foo');

        $this->assertTrue($has_foo);
    }

    public function test_has_method_returns_false_when_array_key_does_not_exist()
    {
        $request = new HttpRequest();

        $has_foo = $request->has('foo');

        $this->assertFalse($has_foo);
    }
}
