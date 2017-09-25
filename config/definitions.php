<?php

return [
    App\Contracts\PdfConversion::class => new App\Support\PrincePdfConversion(),
    App\Contracts\MetricsLogger::class => new App\Support\SqliteMetricsLogger(),
];
