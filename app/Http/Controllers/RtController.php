<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Http\Resources\UserResource;

class RtController extends Controller
{
    public function show () {
        $user = Auth::user();

        return new UserResource($user);
    }

    public function updateProfile (Request $request) {
        $user = Auth::user();

        $user->update($request->all());

        return response()->json([
            'message' => 'profil berhasil di update',
            'data' => new UserResource($user)
        ]);
    }
}
