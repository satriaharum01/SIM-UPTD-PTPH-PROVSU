<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Laporan;
use App\Models\Notif;
use App\Models\OPT;
use App\Models\Petugas;
use App\Models\Tanaman;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\WilayahKerja;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    public $hari = [
        "","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu","Minggu"
    ];

    public function buat_notif($title, $icon, $color)
    {
        $data = [
            'judul' => $title,
            'status' => 'wait',
            'icon' => $icon,
            'color' => $color,
            'id_user' => Auth::user()->id
        ];

        Notif::create($data);
    }

    //COUNTER ALL

    public function count_laporan_provinsi()
    {
        return Laporan::select('*')->count();
    }

    public function count_laporan_kordinator()
    {
        $kecamatan = Kecamatan::select('id')->where('kabupaten_id', Auth::user()->kabupaten_id)->get()->toArray();
        $wilayahKerja = WilayahKerja::select('id')
                ->whereIn('kecamatan_id', $kecamatan)
                ->get()->toArray();
        $result = Laporan::select('*')->whereIn('wilayah_kerja_id', $wilayahKerja)->count();

        return $result;
    }

    public function count_laporan_petugas()
    {
        $petugas_id = Petugas::where('user_id', Auth::user()->id)->first();
        $result = Laporan::select('*')->where('petugas_id', $petugas_id->id)->count();

        return $result;
    }

    public function count_laporan_menunggu()
    {
        $verify = Verifikasi::select('laporan_id')->where('verifikator_id', Auth::user()->id)->get()->toArray();
        $result = Laporan::select('*')->whereNotIn('laporan_id', $verify)->count();

        return $result;
    }

    public function count_laporan_verifikasi()
    {
        $verify = Verifikasi::select('laporan_id')->where('verifikator_id', Auth::user()->id)->get()->toArray();
        $result = Laporan::select('*')->whereIn('laporan_id', $verify)->count();

        return $result;
    }

    public function count_kabupaten()
    {
        return Kabupaten::select('*')->count();
    }
    
    public function count_kecamatan()
    {
        return Kecamatan::select('*')->count();
    }
    
    public function count_kecamatan_kordinator()
    {
        $result = Kecamatan::select('*')->where('kabupaten_id',Auth::user()->kabupaten_id)->count();

        return $result;
    }
    
    public function count_wilayahKerja()
    {
        return WilayahKerja::select('*')->count();
    }
    
    
    public function count_tanaman()
    {
        return Tanaman::select('*')->count();
    }
    
    public function count_opt()
    {
        return OPT::select('*')->count();
    }
}
