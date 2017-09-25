<?php

/**
 * Get the container or a resolution if a string is passed.
 *
 * @param string|null $dependency
 * @return \DI\Container|mixed
 * @throws InvalidArgumentException|\DI\NotFoundException
 */
function container(string $dependency = null)
{
    $kernel = App\Kernel::instance();

    if ($dependency === null) {
        return $kernel->container();
    }

    return $kernel->container()->get($dependency);
}

/**
 * Get the resolution of the interface passed.
 *
 * @param string $dependency
 * @return mixed
 * @throws InvalidArgumentException|\DI\NotFoundException
 */
function resolve(string $dependency)
{
    return container($dependency);
}
