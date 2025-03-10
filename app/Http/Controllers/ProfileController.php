<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Services\ProfileService;
use App\Models\Profile;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService) {}

    /**
     * Display all profiles
     */
    public function index(): AnonymousResourceCollection
    {

        return ProfileResource::collection(Profile::where('status', Status::ACTIVE)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): ProfileResource|JsonResponse
    {
        $profile = Profile::create([
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName'),
        ]);

        try {
            $profile->image = $this->profileService->storeImages($request->file('image'), $profile->id);
        } catch (FileException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $profile->save();

        return new ProfileResource($profile);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile): ProfileResource
    {
        return new ProfileResource($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): ProfileResource|JsonResponse
    {
        try {
            $imagePath = $this->profileService->storeImages($request->file('image'), $profile->id);
        } catch (FileException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $profile->update([
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName'),
            'image' => $imagePath,
            'status' => $request->input('status'),
        ]);

        return new ProfileResource($profile);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile): bool
    {
        // TODO Delete profile images
        return $profile->delete();
    }
}
