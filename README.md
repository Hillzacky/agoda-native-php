# agoda-native-php
- Fully native PHP, no Composer
- Retry + Signature + Idempotency included
- Bulk 365-day rate & inventory support
- Multi-property ready
- Safe reservation pull & duplicate prevention
- Queue & worker system for background jobs
- Cron automation ready
- Webhook for real-time booking

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
## Workflow Diagram
```
+------------------+       +------------------+
|  RateEngine      |-----> |   OTAService     |
|  InventoryEngine |-----> |   OTAService     |
+------------------+       +------------------+
         |                          |
         v                          v
   Cron Jobs/Queue             Agoda API
         |
         v
+------------------+
| ReservationEngine|
|   (pull YCS)     |
+------------------+
         |
         v
+------------------+
|  Reservation DB  |
+------------------+
         |
         v
+------------------+
| Webhook Receiver |
| (real-time push) |
+------------------+
```

## Inisial
```
<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../core/Env.php';
Env::load();

echo "Library Loaded OK!";
```

## Core Classes
### Database — PDO singleton:
``` PHP
require_once 'core/Database.php';
$db = Database::connect();
$stmt = $db->query("SELECT * FROM properties");
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
```
### Logger — save log:
``` PHP
require_once 'core/Logger.php';
Logger::write('INFO', 'Test log');
```
### Signature — HMAC SHA256:
``` PHP
require_once 'core/Signature.php';
$payload = '{"booking_id":123}';
$secret = 'MY_SECRET';
$signature = Signature::generate($payload, $secret);
```
### HttpClient — HTTP request:
``` PHP
require_once 'core/HttpClient.php';
$client = new HttpClient();
$response = $client->send('GET', 'https://api.example.com');
```
### AgodaClient — API wrapper:
``` PHP
require_once 'core/AgodaClient.php';
$agoda = new AgodaClient();
$response = $agoda->request('GET', '/ycs/reservations');
```
## Models
### Property
``` PHP
require_once 'models/Property.php';
$properties = Property::all();
```
### Room
``` PHP
require_once 'models/Room.php';
$rooms = Room::byProperty(1);
```
### Reservation
``` PHP
require_once 'models/Reservation.php';
Reservation::save([
    'booking_id' => 'AG123456',
    'status'     => 'Confirmed',
    'checkin'    => '2026-03-01',
    'checkout'   => '2026-03-05',
    'guest'      => 'John Doe',
    'amount'     => 1500000
]);
```
## Builders
### OTAXmlBuilder — build OTA XML for rates & inventory:
``` PHP
require_once 'builders/OTAXmlBuilder.php';
$rates = ['2026-03-01'=>1000000,'2026-03-02'=>1150000];
$xmlRate = OTAXmlBuilder::buildBulkRate('HOTEL001','ROOM001',$rates);

$inventory = ['2026-03-01'=>5,'2026-03-02'=>3];
$xmlInv = OTAXmlBuilder::buildBulkAvailability('HOTEL001','ROOM001',$inventory);
```
## Services
### OTAService
``` PHP
require_once 'services/OTAService.php';
$ota = new OTAService();
$ota->pushBulkRate('HOTEL001','ROOM001',$rates);
$ota->pushBulkAvailability('HOTEL001','ROOM001',$inventory);
```
### YCSService
``` PHP
require_once 'services/YCSService.php';
$ycs = new YCSService();
$response = $ycs->getReservations('2026-03-01 00:00:00','2026-03-01 23:59:59');
```
### ContentService
``` PHP
require_once 'services/ContentService.php';
$content = new ContentService();
$content->pushProperty(['hotel_code'=>'HOTEL001','name'=>'Hotel Example']);
$content->pushRoom(['hotel_code'=>'HOTEL001','room_code'=>'ROOM001','name'=>'Deluxe Room']);
```
### PromotionService
``` PHP
require_once 'services/PromotionService.php';
$promo = new PromotionService();
$promo->createPromotion(['hotel_code'=>'HOTEL001','room_code'=>'ROOM001','name'=>'Promo','discount'=>10]);
$promo->updatePromotion(['id'=>1,'discount'=>15]);
$promo->deletePromotion(1);
```
## Engines
### RateEngine
``` PHP
require_once 'engines/RateEngine.php';
$rateEngine = new RateEngine();
$rateEngine->syncYearlyRates(1, 1000000);
```
### InventoryEngine
``` PHP
require_once 'engines/InventoryEngine.php';
$invEngine = new InventoryEngine();
$invEngine->syncInventory(1);
```
### ReservationEngine
``` PHP
require_once 'engines/ReservationEngine.php';
$resEngine = new ReservationEngine();
$resEngine->pullLatest();
```
## Queue System
### JobQueue
``` PHP
require_once 'queue/JobQueue.php';
JobQueue::push('sync_rate',['property_id'=>1,'base_rate'=>1000000]);
$job = JobQueue::next();
```
### Worker
``` Bash
php queue/Worker.php
```
### Webhook Receiver
- File: webhooks/agoda.php
- Validates signature
- Saves booking to DB
- Responds OK to Agoda

[buymeacoffee](buymeacoffee.com/hillzacky)