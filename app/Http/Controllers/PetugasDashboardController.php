<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_petugas');
    }

    public function index()
    {
        $this->data['title'] = 'Dashboard Petugas Lapangan';
        $this->data['laporan'] = $this->count_laporan_petugas();
        $this->data['laporan_menunggu'] = $this->count_laporan_menunggu();
        $this->data['laporan_verifikasi'] = $this->count_laporan_verifikasi();
        $this->data['wilayahKerja'] = $this->get_wilayahKerja_petugas();

        return view('petugas/dashboard/index', $this->data);
    }


}
