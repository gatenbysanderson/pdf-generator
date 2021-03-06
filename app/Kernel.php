<?php

namespace App;

use App\Support\HttpRequest;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

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
        $this->loadEnvironmentVariables();
        
        $this->builder = new ContainerBuilder();
        $this->builder->addDefinitions(basePath('bootstrap/definitions.php'));
        $this->container = $this->builder->build();
        $this->router = new Router(new HttpRequest());
    }

    /**
     * Return the kernel as a singleton.
     *
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
     * Return the container as a singleton.
     *
     * @return \DI\Container
     */
    public function container(): Container
    {
        return $this->container;
    }

    /**
     * Return the router as a singleton.
     *
     * @return \App\Router
     */
    public function router(): Router
    {
        return $this->router;
    }

    /**
     * Initialise the environment variables.
     *
     * @return void
     */
    protected function loadEnvironmentVariables()
    {
        $envFile = '.env';

        if (getenv('ENV') === 'testing') {
            $envFile .= '.testing';
        }

        $dot_env = new Dotenv(basePath(), $envFile);
        $dot_env->load();
    }
}
