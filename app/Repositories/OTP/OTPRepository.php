<?php

namespace App\Repositories\OTP;

use App\Models\OTP;


interface OTPRepository
{
    public function add(OTP $otp, string $identifier): void;

    public function getValidToken(string $request): ?string;
}


