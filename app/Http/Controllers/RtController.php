<?php

namespace App\Http\Controllers;

use App\User;
use App\Warga;
use Carbon\Carbon;
use App\Kesejahteraan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\WargaResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\KesejahteraanResource;

class RtController extends Controller
{

    public function __construct () {
        if (Gate::denies('isRT')) {
            abort(403, 'hello world');
        }
    }

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
                [       'status_user', 2]
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

        $warga_layak_bansos = User::where([
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
            'data_warga' => UserResource::collection($warga_layak_bansos)
        ]);
    }

    public function lapKesehatan (Request $request) {

        $user = Auth::user();

        $tanggal_awal = '2010-01-01';
        $tanggal_akhir = Carbon::today('Asia/Jakarta')->toDateString();

        if ($request->input('tanggal_awal')) {
            $tanggal_awal = $request->input('tanggal_awal');
        }

        if ($request->input('tanggal_akhir')) {
            $tanggal_akhir = $request->input('tanggal_akhir');
        }

        // get warga yang sama dengan RT yang sedang login

        $jumWargaSehat = User::where([
            ['kecamatan', $user->kecamatan],
            ['kelurahan', $user->kelurahan],
            ['rw', $user->rw],
            ['rt', $user->rt],
            ['status_user', 2]
        ])->whereHas('warga.latestKesehatan', function (Builder $query) use ($tanggal_awal, $tanggal_akhir) {
            $query->isSehat()->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
        })->count();

        $jumWargaSakit = User::where([
            ['kecamatan', $user->kecamatan],
            ['kelurahan', $user->kelurahan],
            ['rw', $user->rw],
            ['rt', $user->rt],
            ['status_user', 2]
        ])->whereHas('warga.latestKesehatan', function (Builder $query) use ($tanggal_awal, $tanggal_akhir) {
            $query->isSakit()->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
        })->count();

        $listWargaSakit = User::where([
            ['kecamatan', $user->kecamatan],
            ['kelurahan', $user->kelurahan],
            ['rw', $user->rw],
            ['rt', $user->rt],
            ['status_user', 2]
        ])->whereHas('warga.kesehatan', function (Builder $query) use ($tanggal_awal, $tanggal_akhir) {
            $query->latest()->take(1)->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
        })->get();

        $WargaSakit = User::where([
            ['kecamatan', $user->kecamatan],
            ['kelurahan', $user->kelurahan],
            ['rw', $user->rw],
            ['rt', $user->rt],
            ['status_user', 2]
        ])->with(['warga' => function ($warga) use ($tanggal_awal, $tanggal_akhir) {
            return $warga->with(['kesehatan' => function ($kesehatan) use ($tanggal_awal, $tanggal_akhir) {
                return $kesehatan->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
            }]);
        }])
        ->get();

        return response()->json([
            'jumlah_warga_sehat' => $jumWargaSehat,
            'jumlah_warga_sakit' => $jumWargaSakit,
            'data_warga_sakit' => UserResource::collection($listWargaSakit)
        ]);

    }

    public function kesehatan (Request $request) {
        $user = Auth::user();

        $tanggal_awal = '2010-01-01';
        $tanggal_akhir = Carbon::today('Asia/Jakarta')->toDateString();

        if ($request->input('tanggal_awal')) {
            $tanggal_awal = $request->input('tanggal_awal');
        }

        if ($request->input('tanggal_akhir')) {
            $tanggal_akhir = $request->input('tanggal_akhir');
        }

        $wargas = User::getWarga($user->kecamatan, $user->kelurahan, $user->rw, $user->rt)
                    ->with(['warga' => function ($warga) use ($tanggal_awal, $tanggal_akhir) {
                        return $warga->with(['latestKesehatan' => function ($kesehatan) use ($tanggal_awal, $tanggal_akhir) {
                            return $kesehatan->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
                        }]);
                    }])
                    ->get();

        $tidak_punya_data_sakit = User::getWarga($user->kecamatan, $user->kelurahan, $user->rw, $user->rt)
                    ->whereDoesntHave('warga.kesehatan', function (Builder $query) use ($tanggal_awal, $tanggal_akhir) {
                        $query->whereBetween('tgl_isi', [$tanggal_awal, $tanggal_akhir]);
                    })
                    ->count();

        $warga_sakit = $this->sakit($wargas);
        $warga_sehat = $this->sehat($wargas) + $tidak_punya_data_sakit;
        $id_warga_sakit = $this->dataWargaSakit($wargas);

        $data_warga_sakit = User::whereIn('id', $id_warga_sakit)->with('warga')->get();

        return response()->json([
            'jumlah_warga_sakit' => $warga_sakit,
            'jumlah_warga_sehat' => $warga_sehat,
            // 'array' => $this->dataWargaSakit($wargas),
            'data_warga_sakit' => UserResource::collection($data_warga_sakit),
            // 'warga' => UserResource::collection($wargas),
        ]);
    }

    public function sakit (Collection $data) {
        $warga_sakit = 0;

        foreach ($data as $warga) {

            if($warga->warga->latestKesehatan == null) {
                continue;
            }

            if ($warga->warga->latestKesehatan->demam == 1 || $warga->warga->latestKesehatan->batuk_kering == 1 || $warga->warga->latestKesehatan->hidung_tersumbat == 1 || $warga->warga->latestKesehatan->pilek == 1 || $warga->warga->latestKesehatan->sakit_tenggorokan == 1 || $warga->warga->latestKesehatan->diare == 1 ||$warga->warga->latestKesehatan->sulit_bernafas == 1 ) {
                $warga_sakit++;
            }
        }

        return $warga_sakit;
    }

    public function sehat (Collection $data) {
        $warga_sehat = 0;

        foreach ($data as $warga) {

            if($warga->warga->latestKesehatan == null) {
                continue;
            }

            if ($warga->warga->latestKesehatan->demam == 0 && $warga->warga->latestKesehatan->batuk_kering == 0 && $warga->warga->latestKesehatan->hidung_tersumbat == 0 && $warga->warga->latestKesehatan->pilek == 0 && $warga->warga->latestKesehatan->sakit_tenggorokan == 0 && $warga->warga->latestKesehatan->diare == 0 && $warga->warga->latestKesehatan->sulit_bernafas == 0 ) {
                $warga_sehat++;
            }
        }

        return $warga_sehat;
    }

    public function dataWargaSakit (Collection $data = null) {
        $data_warga = array();

        foreach ($data as $warga) {

            if($warga->warga->latestKesehatan == null) {
                continue;
            }

            if ($warga->warga->latestKesehatan->demam == 1 || $warga->warga->latestKesehatan->batuk_kering == 1 || $warga->warga->latestKesehatan->hidung_tersumbat == 1 || $warga->warga->latestKesehatan->pilek == 1 || $warga->warga->latestKesehatan->sakit_tenggorokan == 1 || $warga->warga->latestKesehatan->diare == 1 ||$warga->warga->latestKesehatan->sulit_bernafas == 1 ) {
                array_push($data_warga, $warga->id);
            }
        }

        return $data_warga;
    }
}
