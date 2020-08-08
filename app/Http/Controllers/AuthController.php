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

        $user = new User;

        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->nama = $request->input('nama');
        $user->nik = $request->input('nik');
        $user->kecamatan = $request->input('kecamatan');
        $user->kelurahan = $request->input('kelurahan');
        $user->rw = $request->input('rw');
        $user->rt = $request->input('rt');
        $user->status_user = 2;

        $user->save();

        $warga = new Warga;

        $warga->no_kk = $request->input('no_kk');
        $warga->jenis_kelamin = $request->input('jenis_kelamin');
        $warga->tanggal_lahir = $request->input('tanggal_lahir');
        $warga->alamat = $request->input('alamat');
        $warga->no_hp = $request->input('no_hp');
        $warga->flag_hamil = $request->input('flag_hamil');
        $warga->flag_paru = $request->input('flag_paru');
        $warga->flag_jantung = $request->input('flag_jantung');
        $warga->flag_autoimun = $request->input('flag_autoimun');
        $warga->flag_diabet = $request->input('flag_diabet');
        $warga->flag_ginjal = $request->input('flag_ginjal');
        $warga->flag_liver = $request->input('flag_liver');
        $warga->flag_hipertensi = $request->input('flag_hipertensi');
        $warga->flag_perokok = $request->input('flag_perokok');

        $user->warga()->save($warga);

        $response  = [
            'message' => 'registrasi warga berhasil',
            'data' => new UserResource($user->load('warga'))
        ];

        return response()->json($response);
    }

    public function login (Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $status_user = $request->input('status_user');

        $user = User::where('username', $username)->first();

        if (!$user) { // email tidak terdaftar di database
            return response()->json([
                "message"   => "email not found",
            ], 401);
        }

        if (Hash::check($password, $user->password)) { // valid login

            if ($user->status_user == $status_user) {
                $token = $this->getToken();

                $user->token = $token;

                $user->save();

                $response = [
                    "message"   => 'Login Success',
                    "token" => $token
                ];
            } else {
                $response = [
                    'message' => 'status user yang anda masukkan salah'
                ];
            }

        } else {
            $response = [
                'message' => 'password yang anda masukkan salah'
            ];
            
        }

        return response()->json($response);
    }

    public function logout () {
        $user = Auth::user();

        if($user) {
            $user->token = null;
            $user->save();

            $response = [
                'message'   => 'logout success',
                'token' => $user->token
            ];
        }
        else {
            $response = [
                'message'   => "logout failed",
                'reason'    => "invalid token"    
            ];
        }

        return response()->json($response);
    }

    public function changePassword (Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required', 
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        $user = Auth::user();
        
        $old_password = $request->input('old_password');

        if (Hash::check($old_password, $user->password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            $response = [
                'Message' => 'Password Berhasil Diganti'
            ];
        } else {
            $response = [
                'Message' => 'Password Gagal Diganti'
            ];
        }
        
        return response()->json($response);
    }

    public function getToken () {
        return rand(100, 500);
    }
}
