<?php

class YCSService
{
    private $client;

    public function __construct()
    {
        $this->client = new AgodaClient();
    }

    public function getReservations($from, $to)
    {
        $endpoint = "/ycs/reservations?fromDate=$from&toDate=$to";

        return $this->client->request(
            "GET",
            $endpoint,
            '',
            "application/json"
        );
    }
}