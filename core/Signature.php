<?php

class Signature
{
    public static function generate($payload, $secret)
    {
        return hash_hmac('sha256', $payload, $secret);
    }
}