<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Admin';
        $this->data['laporan'] = $this->count_laporan_provinsi();
        $this->data['laporan_menunggu'] = $this->count_laporan_menunggu();
        $this->data['laporan_verifikasi'] = $this->count_laporan_verifikasi();
        $this->data['kabupaten'] = $this->count_kabupaten();
        $this->data['kecamatan'] = $this->count_kecamatan();
        $this->data['wilayahKerja'] = $this->count_wilayahKerja();
        $this->data['tanaman'] = $this->count_tanaman();
        $this->data['opt'] = $this->count_opt();


        return view('admin/dashboard/index', $this->data);
    }


}
