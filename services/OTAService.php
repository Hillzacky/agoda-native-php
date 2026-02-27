<?php

require_once __DIR__ . '/../builders/OTAXmlBuilder.php';

class OTAService
{
    private $client;

    public function __construct()
    {
        $this->client = new AgodaClient();
    }

    public function pushBulkRate($hotelCode, $roomCode, $rates)
    {
        $xml = OTAXmlBuilder::buildBulkRate($hotelCode, $roomCode, $rates);

        return $this->client->request(
            "POST",
            "/ota/OTA_HotelRateAmountNotifRQ",
            $xml,
            "application/xml"
        );
    }

    public function pushBulkAvailability($hotelCode, $roomCode, $inventory)
    {
        $xml = OTAXmlBuilder::buildBulkAvailability($hotelCode, $roomCode, $inventory);

        return $this->client->request(
            "POST",
            "/ota/OTA_HotelAvailNotifRQ",
            $xml,
            "application/xml"
        );
    }
}