<?php

namespace App\Support;

class HttpRequest
{
    /**
     * @var array
     */
    protected $request;

    /**
     * @var array
     */
    protected $files;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->files = $_FILES;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->request);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function input(string $key, $default = null)
    {
        return $this->has($key) ? $this->request[$key] : $default;
    }
}
