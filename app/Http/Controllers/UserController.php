<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        if ($request->user()->avatar) {
            Storage::disk('public')->delete($request->user()->avatar);
        }

        $path = $request->file('avatar')->store(
            'avatars/' . $request->user()->id,
            'public'
        );

        $request->user()->update([
            'avatar' => $path
        ]);

        return response()->json([
            'avatar' => URL::to(Storage::disk('public')->url($path))
        ]);
    }
}