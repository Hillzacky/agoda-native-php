<?php

class ContentService
{
    private $client;

    public function __construct()
    {
        $this->client = new AgodaClient();
    }

    public function pushProperty($data)
    {
        return $this->client->request(
            "POST",
            "/content/property",
            json_encode($data),
            "application/json"
        );
    }

    public function pushRoom($data)
    {
        return $this->client->request(
            "POST",
            "/content/room",
            json_encode($data),
            "application/json"
        );
    }
}