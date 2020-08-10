<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use App\Warga;
use App\Kesejahteraan;
use App\Http\Resources\UserResource;
use App\Http\Resources\WargaResource;
use App\Http\Resources\KesejahteraanResource;

class RtController extends Controller
{
    public function show () {
        $user = Auth::user();

        $warga = User::where([
            ['kecamatan', $user->kecamatan],
            
        ]);

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

    public function lapKesejahteraan () {

        $user = Auth::user();

        $penghasilanData = array(

            '1' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->penghasilan(1);
            })->count(),

            '2' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->penghasilan(2);
            })->count(),

            '3' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->penghasilan(3);
            })->count(),

            '4' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->penghasilan(4);
            })->count(),

        );

        $total_data_penghasilan = 0;

        foreach ($penghasilanData as $penghasilan) {
            $total_data_penghasilan += $penghasilan;
        }

        $pekerjaanData = array(
            'phk' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->pehaka();
            })->count(),

            'usaha' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->usaha();
            })->count(),

            'bekerja' => User::where([
                ['kecamatan', $user->kecamatan],
                ['kelurahan', $user->kelurahan],
                ['rw', $user->rw],
                ['rt', $user->rt],
                ['status_user', 2]
            ])->whereHas('warga.kesejahteraan', function (Builder $query) {
                $query->bekerja();
            })->count(),
        );

        // Warga yang layak bansos

        $warga_bansos = User::where([
            ['kecamatan', $user->kecamatan],
            ['kelurahan', $user->kelurahan],
            ['rw', $user->rw],
            ['rt', $user->rt],
            ['status_user', 2]
        ])->whereHas('warga.kesejahteraan', function (Builder $query) {
            $query->pehaka()->tidakUsaha()->penghasilan('1');
        })->get();

        return response()->json([
            'data_penghasilan' => [
                '1' => $penghasilanData['1'],
                '2' => $penghasilanData['2'],
                '3' => $penghasilanData['3'],
                '4' => $penghasilanData['4'],
                'total_data_penghasilan' => $total_data_penghasilan
            ],
            'data_pekerjaan' => [
                'phk' => $pekerjaanData['phk'],
                'usaha' => $pekerjaanData['usaha'],
                'bekerja' => $pekerjaanData['bekerja']
            ],
            'data_warga' => UserResource::collection($warga_bansos)
        ]);
    }

}
