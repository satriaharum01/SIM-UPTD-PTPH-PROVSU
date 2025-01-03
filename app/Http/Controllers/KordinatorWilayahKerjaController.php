<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Kecamatan;
use App\Models\Petugas;
use App\Models\User;
use App\Models\WilayahKerja;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class KordinatorWilayahKerjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_kordinator');

        $this->page = 'kordinator/wilayah_kerja';
        $this->data['title'] = 'Data Wilayah Kerja';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Wilayah Kerja';

        return view('kordinator/wilayah_kerja/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new WilayahKerja())->getField();
        $this->data['action'] = 'kordinator/wilayah_kerja/save';

        return view('kordinator/wilayah_kerja/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = WilayahKerja::find($id);
        $this->data['title'] = 'Data Kecamatan';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new WilayahKerja())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'kordinator/wilayah_kerja/update/'.$rows->id;

        return view('kordinator/wilayah_kerja/detail', $this->data);
    }
    public function json()
    {
        $kecamatan = Kecamatan::select('id')->get()->toArray();
        $data = WilayahKerja::select('*')
                ->whereIn('kecamatan_id',$kecamatan)
                ->get();
        foreach($data as $row)
        {
            $row->nama_kecamatan = $row->cariKecamatan->nama_kecamatan;
            $row->jumlah_petugas = Petugas::where('wilayah_kerja_id',$row->id)->count();
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = WilayahKerja::find($id);

        $fillAble = (new WilayahKerja())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new WilayahKerja())->getFillable();
        WilayahKerja::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = WilayahKerja::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
