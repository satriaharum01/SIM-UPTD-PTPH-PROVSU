<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Kecamatan;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class KordinatorKecamatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_kordinator');

        $this->page = 'kordinator/kecamatan';
        $this->data['title'] = 'Data Kecamatan';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Kecamatan';

        return view('kordinator/kecamatan/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new Kecamatan())->getField();
        $this->data['action'] = 'kordinator/kecamatan/save';

        return view('kordinator/kecamatan/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Kecamatan::find($id);
        $this->data['title'] = 'Data Kecamatan';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Kecamatan())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'kordinator/kecamatan/update/'.$rows->id;

        return view('kordinator/kecamatan/detail', $this->data);
    }
    public function json()
    {
        $data = Kecamatan::select('*')
                ->where('kabupaten_id',Auth::user()->kabupaten_id)
                ->orderby('nama_kecamatan', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Kecamatan::find($id);

        $fillAble = (new Kecamatan())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Kecamatan())->getFillable();
        Kecamatan::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Kecamatan::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
