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

/**
 * Get the project root path.
 *
 * @param string $path
 * @return string
 */
function basePath(string $path = ''): string
{
    return realpath(dirname(__DIR__)) . '/' . trim($path, '/');
}

/**
 * Get the public path.
 *
 * @param string $path
 * @return string
 */
function publicPath(string $path = ''): string
{
    return basePath('public/' . trim($path, '/'));
}

/**
 * Get the storage path.
 *
 * @param string $path
 * @return string
 */
function storagePath(string $path = ''): string
{
    return basePath('storage/' . trim($path, '/'));
}

/**
 * Die and dump.
 *
 * @return void
 */
function dd()
{
    var_dump(func_get_args());
    die;
}
