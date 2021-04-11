<?php
namespace App\Repositories\OTP;
use App\Models\OTP;
use App\Models\Person;


interface OTPRepository
{
    public function add(OTP $otp, string $identifier): void;
    public function getValidToken(string $request): ?string;
}


