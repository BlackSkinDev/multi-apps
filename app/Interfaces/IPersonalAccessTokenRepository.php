<?php

namespace App\Interfaces;

interface IPersonalAccessTokenRepository
{
    public function findById(int $id);
    public function fetchUser(int $id);

}
