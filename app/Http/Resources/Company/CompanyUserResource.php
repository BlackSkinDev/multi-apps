<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'image'     => $this->image ? $this->photo : null,
            'initial'   => $this->initials,
            'role'      => $this->role
        ];
    }
}
