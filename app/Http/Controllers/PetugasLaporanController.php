<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Petugas;
use App\Models\Laporan;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class PetugasLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_petugas');

        $this->page = 'petugas/laporan';
        $this->data['title'] = 'Data Laporan';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Laporan';

        return view('petugas/laporan/index', $this->data);
    }

    public function new()
    {
        $this->data['sub_title'] = 'Tambah Data ';
        $this->data['fieldTypes'] = (new Laporan())->getField();
        $this->data['action'] = 'petugas/laporan/save';

        return view('petugas/laporan/detail', $this->data);
    }

    public function edit($id)
    {
        $rows = Laporan::find($id);
        $this->data['title'] = 'Data Laporan';
        $this->data['sub_title'] = 'Edit Data ';
        $this->data['fieldTypes'] = (new Laporan())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'petugas/laporan/update/'.$rows->id;

        return view('petugas/laporan/detail', $this->data);
    }
    public function json()
    {
        $petugas_id = Petugas::where('user_id',Auth::user()->id)->first();
        $data = Laporan::select('*')
                ->where('petugas_id',$petugas_id->id)
                ->orderby('tanggal_laporan', 'DESC')
                ->get();
                
        foreach($data as $row)
        {
            $row->nama_kecamatan = $row->cariKecamatan->nama_kecamatan;
            $row->wilayah_kerja = $row->cariWilayahKerja->nama_daerah;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->tanggal_laporan = date('d F Y',strtotime($row->tanggal_laporan));
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
