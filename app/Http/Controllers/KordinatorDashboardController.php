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

        return view('kordinator/dashboard/index', $this->data);
    }


}
