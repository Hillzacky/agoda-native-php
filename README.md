# agoda-native-php
library php untuk agoda

## Struktur File
```
Library/
│
├── .env
├── autoload.php
├── config.php
│
├── core/
│   ├── Database.php
│   ├── Logger.php
│   ├── Signature.php
│   ├── Response.php
│   ├── HttpClient.php
│   └── AgodaClient.php
│
├── models/
│   ├── Property.php
│   ├── Room.php
│   └── Reservation.php
│
├── builders/
│   └── OTAXmlBuilder.php
│
├── services/
│   ├── OTAService.php
│   ├── YCSService.php
│   ├── ContentService.php
│   └── PromotionService.php
│
├── webhooks/
│   └── agoda.php
│
├── monitoring/
│   └── HealthCheck.php
│
├── engines/
│   ├── RateEngine.php
│   ├── InventoryEngine.php
│   └── ReservationEngine.php
│
├── queue/
│   ├── JobQueue.php
│   └── Worker.php
│
├── cron/
│   ├── sync_rates.php
│   ├── sync_inventory.php
│   └── pull_reservations.php
└── vendor/
```



## Inisial
```
<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../core/Env.php';
Env::load();

echo "Library Loaded OK!";
```
