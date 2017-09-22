<?php

// Register app dependencies here.

// Register the DI.
$builder = new DI\ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/definitions.php');
$container = $builder->build();

// TODO: Refactor this code into a namespaced entry point.
$pdfConverter = $container->get(App\Contracts\PdfConversion::class);

var_dump($pdfConverter);
