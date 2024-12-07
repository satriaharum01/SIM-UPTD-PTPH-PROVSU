<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KordinatorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_kordinator');
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Kordinator Kabupaten';
        $this->data['laporan'] = $this->count_laporan_kordinator();
        $this->data['laporan_menunggu'] = $this->count_laporan_menunggu();
        $this->data['laporan_verifikasi'] = $this->count_laporan_verifikasi();
        $this->data['petugas'] = $this->count_petugas_kordinator();
        $this->data['kecamatan'] = $this->count_kecamatan_kordinator();
        $this->data['wilayahKerja'] = $this->count_wilayahKerja_kordinator();

        return view('kordinator/dashboard/index', $this->data);
    }


}
