<?php

require_once __DIR__ . '/../engines/InventoryEngine.php';

$engine = new InventoryEngine();
$engine->syncInventory(1);