<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Notif;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public $bulan = array('','Januari','Febuari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    public $hari = [
        "","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu","Minggu"
    ];

    public $klasifikasi = array('A','B','C');


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
}
