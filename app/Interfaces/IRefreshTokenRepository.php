<?php

namespace App\Interfaces;

use App\Models\RefreshToken;

interface IRefreshTokenRepository
{
    public function create(array $data);
    public function findByToken(string $token);
    public function delete(RefreshToken $refreshToken);

}
