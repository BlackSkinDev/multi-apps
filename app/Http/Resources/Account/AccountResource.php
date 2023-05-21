<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'      =>   $this->name,
            'username'  =>   $this->username,
            'email'     =>   $this->email,
            'image'     =>   $this->photo,
            'initial'   =>   $this->initials,
            'bio'       =>   $this->bio,
            'linkedin'  =>   $this->linkedin,
            'phone'     =>   $this->phone
        ];
    }
}
