<?php

class AgodaClient
{
    private $config;
    private $http;

    public function __construct()
    {
        $cfg = require __DIR__ . '/../config.php';
        $env = $cfg['environment'];

        $this->config = $cfg[$env];
        $this->http   = new HttpClient();
    }

    public function request($method, $endpoint, $payload = '', $contentType = 'application/json')
    {
        $url = $this->config['base_url'] . $endpoint;

        $signature = Signature::generate($payload, $this->config['secret']);

        $headers = [
            "Content-Type: $contentType",
            "X-API-KEY: " . $this->config['api_key'],
            "X-SIGNATURE: $signature",
            "Idempotency-Key: " . uniqid()
        ];

        Logger::write("REQUEST", $endpoint);

        $response = $this->http->send($method, $url, $headers, $payload);

        Logger::write("RESPONSE", $response->status);

        return $response;
    }
}