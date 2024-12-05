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

        return view('admin/dashboard/index', $this->data);
    }


}
