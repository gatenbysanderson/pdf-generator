<?php

namespace App;

use DI\ContainerBuilder;

class Kernel
{
    /**
     * @var \App\Kernel
     */
    private static $instance;

    /**
     * @var \DI\ContainerBuilder
     */
    private $builder;

    /**
     * @var \DI\Container
     */
    private $container;

    /**
     * @var \App\Router
     */
    private $router;

    /**
     * Kernel constructor.
     */
    private function __construct()
    {
        $this->builder = new ContainerBuilder();
        $this->builder->addDefinitions(dirname(__DIR__) . '/config/definitions.php');

        $this->container = $this->builder->build();

        $this->router = new Router($this);
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
     * @return Router
     */
    public function router()
    {
        return $this->router;
    }
}
