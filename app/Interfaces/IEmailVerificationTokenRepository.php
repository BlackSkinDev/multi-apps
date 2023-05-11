<?php

namespace App\Interfaces;

use App\Models\EmailVerificationToken;

interface IEmailVerificationTokenRepository
{
    public function create(array $data);
    public function findByToken(string $token);
    public function delete(EmailVerificationToken $token);

}
