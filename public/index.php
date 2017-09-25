<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$kernel = App\Kernel::instance();

$kernel->router()->handle();
