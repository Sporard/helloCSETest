<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileService
{
    /**
     * Stores images for profile
     *
     * @throws FileException
     */
    public function storeImages($image, int $profileId): string
    {
        $imageFolder = 'user_'.$profileId;
        try {
            $storageLink = Storage::disk('public_images')->put($imageFolder, $image);
            $imagePath = asset('images/'.$storageLink);
        } catch (Exception $exception) {
            throw new FileException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $imagePath;
    }
}
