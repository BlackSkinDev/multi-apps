<?php

namespace App\Interfaces;

interface IEmailVerificationTokenRepository
{

    public function create(array $data);

}
