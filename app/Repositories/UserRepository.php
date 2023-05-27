<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;
use Laravel\Sanctum\NewAccessToken;

class UserRepository implements IUserRepository
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Create new user
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Search logged in user company users
     */
    public function searchCompanyUsers(User $user,$q=null)
    {
        return $this->model->enabled()
                ->where('company_id',$user->company_id)
                ->where('id','!=',$user->id)
                ->when($q,function ($query) use ($q){
                    $query->where('name', 'LIKE', "%$q%");
                })
                ->get();
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email):User|null
    {
        return $this->model->enabled()->where('email',$email)->first();
    }


    /**
     * Find user by uuid
     */
    public function findByUuid(string $uuid)
    {
        return $this->model->enabled()->where('uuid',$uuid)->first();
    }

    /**
     * Update  user
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete  user
     */
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }

    /**
     * Verify user
     */
    public function verifyEmail(User $user): void
    {
          $user->update(['email_verified_at' => now()]);
    }

    /**
     * create  user token
     */
    public function createUserToken(User $user): NewAccessToken
    {
        return $user->createToken("auth-token");
    }

    /**
     * delete user tokens
     */
    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * attach company to user
     */
    public function attachCompany(User $user,$company_id)
    {
        $user->update(['company_id'=>$company_id]);
    }

    /**
     * attach profile picture to user
     */
    public function attachProfilePicture(User $user,$filepath)
    {
        $user->update(['image'=>$filepath]);
    }


}
