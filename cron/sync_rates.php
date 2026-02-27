<?php

require_once __DIR__ . '/../engines/RateEngine.php';

$engine = new RateEngine();
$engine->syncYearlyRates(1, 1000000);