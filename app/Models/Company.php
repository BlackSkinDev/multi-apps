<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','logo'];

    /**
     * get user photo
     *
     */
    public function getImageAttribute(): string
    {
        $defaultLogoPath = url('/images/default-logo.png');
        $logoFolder = 'public/company-logos';

        if ($this->logo && Storage::exists($logoFolder . '/' . $this->logo)) {
            return url(Storage::url($logoFolder . '/' . $this->logo));
        } else {
            return $defaultLogoPath;
        }
    }
}
