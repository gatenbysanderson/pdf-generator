<?php

require realpath(dirname(__DIR__) . '/bootstrap/autoload.php');

$kernel->router()->handle();
