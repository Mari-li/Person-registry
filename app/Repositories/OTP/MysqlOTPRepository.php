<?php

namespace App\Repositories\OTP;

use App\Models\OTP;
use Medoo\Medoo;

class MysqlOTPRepository implements OTPRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'person_registry',
            'server' => 'localhost',
            'username' => 'marija',
            'password' => 'mzm08111'
        ]);
    }

    public function add(OTP $otp, string $identifier): void
    {
        $this->database->insert('otp', [
            'user_personal_code' => $identifier,
            'otp_token' => $otp->getToken(),
            'otp_expiration_time' => $otp->getExpirationTime(),
        ]);
    }


    public function getValidToken(string $request): ?string
    {
        return $this->database->select(
            'otp',
            'otp_token',
            ['otp_token' => $request,
                'otp_expiration_time[>]' => date('Y-m-d H:i:s')])[0];
    }
}