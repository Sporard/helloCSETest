<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProfileController extends Controller
{
    /**
     * Display all profiles
     */
    public function index(): AnonymousResourceCollection
    {
        return ProfileResource::collection(Profile::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request): ProfileResource
    {
        $profile = Profile::create($request->validated());

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
