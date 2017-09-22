<?php

namespace App;

class Router
{
    /**
     * @var \App\Kernel
     */
    protected $kernel;

    /**
     * Router constructor.
     *
     * @param \App\Kernel $kernel
     */
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param array $request
     */
    public function handle(array $request)
    {
        //
    }
}
