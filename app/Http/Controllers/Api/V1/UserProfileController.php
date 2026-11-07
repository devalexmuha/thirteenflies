<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        return UserProfileResource::make($request->user()->userProfile);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            $webp = ImageManager::gd()
                ->read($request->file('avatar')->getRealPath())
                ->orient()
                ->cover(800, 800)
                ->toWebp(80);

            $validated['avatar'] = 'avatars/'.Str::uuid().'.webp';
            Storage::disk('public')->put($validated['avatar'], (string) $webp);
        }

        $profile = $request->user()->userProfile;
        $profile->update($validated);

        return UserProfileResource::make($profile);
    }

    /**
     * Delete the user account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();
        $user->delete();

        return response()->noContent();
    }
}
