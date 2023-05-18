<?php

namespace App\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data);
    public function findByEmail(string $email);
    public function update(User $user, array $data);
    public function destroy(User $user);
    public function verifyEmail(User $user);
    public function createUserToken(User $user);
    public function deleteTokens(User $user);
    public function attachCompany(User $user,int $company_id);
    public function attachProfilePicture(User $user,$filepath);
}
