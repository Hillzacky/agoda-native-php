<?php

require_once __DIR__ . '/../engines/ReservationEngine.php';

$engine = new ReservationEngine();
$engine->pullLatest();