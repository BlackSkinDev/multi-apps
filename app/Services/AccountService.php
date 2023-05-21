<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Interfaces\IUserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountService
{
    public function __construct(
        FileService         $fileService,
        IUserRepository     $userRepository
    ) {
        $this->fileService        = $fileService;
        $this->userRepository     = $userRepository;
    }

    /**
     * Upload user profile picture
     * @param string $file
     * @throws ClientErrorException
     */
    public function uploadProfilePicture($file): void
    {
        DB::beginTransaction();

        try {

            $filepath = $this->fileService->uploadProfilePicture($file);

            $this->userRepository->attachProfilePicture(auth()->user(),$filepath);

            DB::commit();

        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            throw new ClientErrorException(__('validation.error_occurred'));
        }

    }

    /**
     * Upload user profile picture
     * @param array $data
     */
    public function updateUserInfo(array $data): void
    {
        $this->userRepository->update(auth()->user(),$data);

    }







}
