<?php

class Response
{
    public $status;
    public $body;

    public function __construct($status, $body)
    {
        $this->status = $status;
        $this->body   = $body;
    }

    public function isSuccess()
    {
        return $this->status >= 200 && $this->status < 300;
    }

    public function json()
    {
        return json_decode($this->body, true);
    }
}