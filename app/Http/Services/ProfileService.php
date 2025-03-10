<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileService
{
    const STORAGE_DISK = 'public_images';

    /**
     * Stores images for profile
     *
     * @throws FileException
     */
    public function storeImages($image, int $profileId): string
    {
        $imageFolder = 'user_'.$profileId;
        try {
            $storageLink = Storage::disk(ProfileService::STORAGE_DISK)->put($imageFolder, $image);
            $imagePath = asset('images/'.$storageLink);
        } catch (Exception $exception) {
            throw new FileException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $imagePath;
    }

    public function deleteImages(int $profileId): bool
    {
        return Storage::disk(ProfileService::STORAGE_DISK)->deleteDirectory('user_'.$profileId);
    }
}
