<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\OPT;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class AdminOPTController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

        $this->page = 'admin/opt';
        $this->data['title'] = 'Data Organisme Penggangu Tanaman';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Tanaman';

        return view('admin/opt/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new OPT())->getField();
        $this->data['action'] = 'admin/opt/save';

        return view('admin/opt/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = OPT::find($id);
        $this->data['title'] = 'Data Organisme Penggangu Tanaman';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new OPT())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'admin/opt/update/'.$rows->id;

        return view('admin/opt/detail', $this->data);
    }
    public function json()
    {
        $data = OPT::select('*')
                ->orderby('nama_opt', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = OPT::find($id);

        $fillAble = (new OPT())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new OPT())->getFillable();
        OPT::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = OPT::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
