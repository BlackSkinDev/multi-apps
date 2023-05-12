<?php

namespace App\Interfaces;

use App\Models\MagicLinkToken;

interface IMagicLinkTokenRepository
{
    public function create(array $data);
    public function findByToken(string $token);
    public function delete(MagicLinkToken $magicLinkToken);

}
