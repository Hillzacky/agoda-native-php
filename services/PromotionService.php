<?php

class PromotionService
{
    private $client;

    public function __construct()
    {
        $this->client = new AgodaClient();
    }

    public function createPromotion($data)
    {
        return $this->client->request(
            "POST",
            "/promotion/create",
            json_encode($data),
            "application/json"
        );
    }

    public function updatePromotion($data)
    {
        return $this->client->request(
            "POST",
            "/promotion/update",
            json_encode($data),
            "application/json"
        );
    }

    public function deletePromotion($id)
    {
        return $this->client->request(
            "DELETE",
            "/promotion/$id"
        );
    }
}