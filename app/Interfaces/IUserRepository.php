<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data);
    public function findByEmail(string $email);
    public function update(User $user, array $data);
    public function destroy(User $user);
}
