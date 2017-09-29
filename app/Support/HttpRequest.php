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
     * Check if the request has the specified key.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->request);
    }

    /**
     * Retrieve the value from the specified key in the request.
     *
     * @param string $key
     * @param null $default
     * @return string|array|null
     */
    public function input(string $key, $default = null)
    {
        return $this->has($key) ? $this->request[$key] : $default;
    }

    /**
     * Retrieve all keys and values in the request.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->request;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasFile(string $key): bool
    {
        return array_key_exists($key, $this->files);
    }

    /**
     * Retrieves all files from the request if no key is given,
     * or a specific file if a key is given.
     *
     * @param string|null $key
     * @return array|null
     */
    public function files(string $key = null)
    {
        if ($key === null) {
            return $this->files;
        }

        return $this->hasFile($key) ? $this->files[$key] : null;
    }

    /**
     * @param string $key
     * @return array|null
     */
    public function file(string $key)
    {
        return $this->files($key);
    }
}
