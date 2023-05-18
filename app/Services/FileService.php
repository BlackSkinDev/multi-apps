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
        return $this->moveToStorage($file,'company-logos');
    }

    /**
     * Upload user profile picture to storage
     * @param $file
     * @return string
     */
    public function uploadProfilePicture($file): string
    {
        return $this->moveToStorage($file,'user-images');
    }

    /**
     * @param $file
     * @param $folder
     * @return string
     */
    public function moveToStorage($file,$folder): string
    {
        $file_name = md5($file->get()) . '.' . $file->extension();
        $file->storeAs("public/$folder", $file_name);
        return $file_name;
    }


}
