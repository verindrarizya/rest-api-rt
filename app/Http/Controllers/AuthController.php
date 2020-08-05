<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Warga;
use App\Http\Resources\UserResource;
use App\Http\Resources\WargaResource;

class AuthController extends Controller
{
    public function registerRT (Request $request) {
        // Validasi

        $user = new User;

        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->nama = $request->input('nama');
        $user->nik = $request->input('nik');
        $user->kecamatan = $request->input('kecamatan');
        $user->kelurahan = $request->input('kelurahan');
        $user->rw = $request->input('rw');
        $user->rt = $request->input('rt');
        $user->status_user = 1;

        $user->save();

        return response()->json([
            'message' => 'registrasi rt berhasil',
            'data' => new UserResource($user)
        ]);
    }

    public function registerWarga (Request $request) {
        // Validasi


    }
}
