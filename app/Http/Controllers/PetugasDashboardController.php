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
        $this->data['title'] = 'Dashboard Petugas Laporan';

        return view('petugas/dashboard/index', $this->data);
    }


}
