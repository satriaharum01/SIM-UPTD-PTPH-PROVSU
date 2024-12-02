<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Kabupaten;
use Yajra\DataTables\Facades\DataTables;

class AdminKabupatenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = 'List Data Kabupaten';

        return view('admin/kabupaten/index', $this->data);
    }

    public function show($id)
    {
        $anime = Kabupaten::findorfail($id);
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = $anime->title;

        return view('admin/kabupaten/show', $this->data);
    }
    public function new()
    {
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = 'Tambah Data ';

        return view('admin/kabupaten/detail', $this->data);
    }

    public function json()
    {
        $data = Kabupaten::select('*')
                ->orderby('nama_kabupaten', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
