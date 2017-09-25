<?php

namespace App;

use DI\ContainerBuilder;

class Kernel
{
    /**
     * @var \App\Kernel
     */
    protected static $instance;

    /**
     * @var \DI\ContainerBuilder
     */
    protected $builder;

    /**
     * @var \DI\Container
     */
    protected $container;

    /**
     * @var \App\Router
     */
    protected $router;

    /**
     * Kernel constructor.
     */
    protected function __construct()
    {
        $this->builder = new ContainerBuilder();
        $this->builder->addDefinitions(dirname(__DIR__) . '/config/definitions.php');

        $this->container = $this->builder->build();
    }

    /**
     * @return \App\Kernel
     */
    public static function instance(): self
    {
        if (! static::$instance instanceof self) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function resolve(string $class)
    {
        return $this->container->get($class);
    }

    /**
     * @param array $request
     */
    public function handle(array $request)
    {
        $router = new Router($this);

        $router->handle($request);
    }
}
