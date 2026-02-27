<?php

require_once __DIR__ . '/../services/OTAService.php';
require_once __DIR__ . '/../models/Room.php';

class RateEngine
{
    private $ota;

    public function __construct()
    {
        $this->ota = new OTAService();
    }

    public function syncYearlyRates($propertyId, $baseRate)
    {
        $rooms = Room::byProperty($propertyId);

        foreach ($rooms as $room) {

            $rates = [];

            for ($i = 0; $i < 365; $i++) {

                $date = date('Y-m-d', strtotime("+$i days"));
                $rate = $baseRate;

                // Weekend markup 15%
                if (date('N', strtotime($date)) >= 6) {
                    $rate *= 1.15;
                }

                $rates[$date] = round($rate);
            }

            $response = $this->ota->pushBulkRate(
                $room['agoda_hotel_id'],
                $room['agoda_room_id'],
                $rates
            );

            Logger::write("RATE_SYNC", "Room {$room['id']} Status: " . $response->status);
        }
    }
}