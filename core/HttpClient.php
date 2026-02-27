<?php

class HttpClient
{
    public function send($method, $url, $headers, $payload, $retry = 3)
    {
        $attempt = 0;

        while ($attempt <= $retry) {

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_TIMEOUT => 60
            ]);

            $response = curl_exec($ch);
            $error    = curl_error($ch);
            $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if (!$error && $status < 500) {
                return new Response($status, $response);
            }

            $attempt++;
            sleep(pow(2, $attempt));
        }

        throw new Exception("HTTP request failed after retries");
    }
}