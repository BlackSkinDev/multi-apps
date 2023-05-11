<?php

namespace App\Interfaces;

use App\Models\PasswordResetToken;

interface IPasswordResetTokenRepository
{
    public function create(array $data);
    public function findByToken(string $token);
    public function delete(PasswordResetToken $token);

}
