<?php

require_once __DIR__ . '/../core/Signature.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../core/Logger.php';

$config = require __DIR__ . '/../config.php';
$env = $config['environment'];
$secret = $config[$env]['secret'];

$payload = file_get_contents("php://input");
$signature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';

$expected = hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    exit("Invalid signature");
}

$data = json_decode($payload, true);

if (!$data) {
    http_response_code(400);
    exit("Invalid payload");
}

Reservation::save([
    'booking_id' => $data['booking_id'],
    'status'     => $data['status'],
    'checkin'    => $data['checkin'],
    'checkout'   => $data['checkout'],
    'guest'      => $data['guest_name'],
    'amount'     => $data['total_amount']
]);

Logger::write("WEBHOOK", "Booking received: " . $data['booking_id']);

echo "OK";