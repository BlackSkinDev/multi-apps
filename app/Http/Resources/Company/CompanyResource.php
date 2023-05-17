<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
              'name'         => $this?->name,
              'description'  => $this->truncate ?  Str::limit(strip_tags($this->description), 20, '...') : $this->description ,
              'image'        => $this->image
        ];
    }
}
