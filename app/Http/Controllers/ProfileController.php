<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\Status;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
    public function store(StoreProfileRequest $request): ProfileResource
    {
        $profile = Profile::create([
            'lastName' => $request->input('lastName'),
            'firstName' => $request->input('firstName'),
        ]);
        $image = $request->file('image');
        $imagePath = 'user_'.$profile->id;
        $storageLink = Storage::disk('public_images')->put($imagePath, $image);

        $profile->image = asset('images/'.$storageLink);
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
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->validated());

        return $profile;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile): bool
    {
        return $profile->delete();
    }
}
