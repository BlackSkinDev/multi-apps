<?php

namespace App\Interfaces;

interface IRefreshTokenRepository
{
    public function create(array $data);
    public function findByToken(string $token);

}
