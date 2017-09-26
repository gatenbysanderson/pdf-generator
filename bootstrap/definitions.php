<?php

return [
    App\Contracts\PdfConversion::class => DI\object(App\Support\PrincePdfConversion::class),
    App\Contracts\MetricsLogger::class => DI\object(App\Support\SqliteMetricsLogger::class),
];
