<?php


namespace App\Models;


use DateTime;

class OTP
{
    private string $token;
    private string $expirationTime;


    public function __construct(string $identifier)
    {
        $this->setToken($identifier);
        $this->setExpirationTime();
    }

    public function setToken(string $identifier)
    {
        $this->token = md5(uniqid($identifier));
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setExpirationTime(): void
    {
        $endTime = strtotime("+1 minute", time());
        $this->expirationTime = date('Y-m-d H:i:s', $endTime);
    }


    public function getExpirationTime(): string
    {
        return $this->expirationTime;
    }

}