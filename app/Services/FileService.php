<?php

namespace App\Services;

class FileService
{

    /**
     * Upload company logo to storage
     * @param $file
     * @return string
     */
    public function uploadCompanyLogo($file): string
    {
        $file_name = md5($file->get()) . '.' . $file->extension();
        $file->storeAs('company-logos', $file_name);
        return $file_name;
    }


}
