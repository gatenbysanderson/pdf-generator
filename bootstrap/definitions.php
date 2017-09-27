<?php

use function DI\object;

return [
    App\Contracts\PdfConversion::class => object(App\Support\PrincePdfConversion::class),
    App\Contracts\MetricsLogger::class => object(App\Support\SqliteMetricsLogger::class),
];
