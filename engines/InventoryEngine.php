<?php

require_once __DIR__ . '/../services/OTAService.php';
require_once __DIR__ . '/../models/Room.php';

class InventoryEngine
{
    private $ota;

    public function __construct()
    {
        $this->ota = new OTAService();
    }

    public function syncInventory($propertyId)
    {
        $rooms = Room::byProperty($propertyId);

        foreach ($rooms as $room) {

            $inventory = [];

            for ($i = 0; $i < 365; $i++) {

                $date = date('Y-m-d', strtotime("+$i days"));
                $inventory[$date] = $room['total_inventory'];
            }

            $response = $this->ota->pushBulkAvailability(
                $room['agoda_hotel_id'],
                $room['agoda_room_id'],
                $inventory
            );

            Logger::write("INV_SYNC", "Room {$room['id']} Status: " . $response->status);
        }
    }
}