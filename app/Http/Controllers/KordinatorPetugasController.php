<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Petugas;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class KordinatorPetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_kordinator');

        $this->page = 'kordinator/petugas';
        $this->data['title'] = 'Data Petugas';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Petugas';

        return view('kordinator/petugas/index', $this->data);
    }

    public function show($id)
    {
        $anime = Kabupaten::findorfail($id);
        $this->data['title'] = 'Data Kabupaten';
        $this->data['sub_title'] = $anime->title;

        return view('kordinator/kabupaten/show', $this->data);
    }
    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new Petugas())->getField();
        $this->data['action'] = 'kordinator/petugas/save';

        return view('kordinator/petugas/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Petugas::find($id);
        $this->data['title'] = 'Data Petugas';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Petugas())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'kordinator/petugas/update/'.$rows->id;

        return view('kordinator/petugas/detail', $this->data);
    }
    public function json()
    {
        $data = Petugas::select('*')
                ->orderby('user_id', 'ASC')
                ->get();

        foreach ($data as $row) {
            $row->name = $row->cariUser->name;
            $row->wilayahKerja = $row->cariWilayahKerja->nama_daerah;

        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Petugas::find($id);

        $fillAble = (new Petugas())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Petugas())->getFillable();
        Petugas::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Petugas::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
