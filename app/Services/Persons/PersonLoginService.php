<?php

namespace App\Services\Persons;

use App\Models\OTP;
use App\Models\Person;
use App\Repositories\OTP\OTPRepository;
use App\Repositories\Persons\PersonsRepository;


class PersonLoginService
{
    private PersonsRepository $personsRepository;
    private OTPRepository $OTPRepository;


    public function __construct(PersonsRepository $personsRepository, OTPRepository $OTPRepository)
    {
        $this->personsRepository = $personsRepository;
        $this->OTPRepository = $OTPRepository;
    }

    public function checkIfRegistered(string $request): ?Person
    {
        $personalCode = trim(str_replace('-', '', $request));
        return $this->personsRepository->get('personal_code', $personalCode)->getOne($personalCode);
    }


    public function createOTP(string $identifier): OTP
    {
        return new OTP($identifier);
    }

    public function storeOTP(OTP $otp, string $identifier): void
    {
        $this->OTPRepository->add($otp, $identifier);
    }


    public function createOTPlink(string $otp): string
    {
        return 'http://localhost:8080/secretPage/auth?=' . $otp;
    }


    public function validateOTP(string $request): bool
    {
        if (is_null($this->OTPRepository->getValidToken($request))) {
            return false;
        }
        return true;
    }

}