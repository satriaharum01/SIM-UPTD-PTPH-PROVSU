<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Laporan;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class KordinatorLaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_kordinator');

        $this->page = 'kordinator/laporan';
        $this->data['title'] = 'Data Laporan';
    }

    public function index()
    {
        $this->data['sub_title'] = 'List Data Laporan';

        return view('kordinator/laporan/index', $this->data);
    }

    public function json()
    {
        $data = Laporan::select('*')
                ->orderby('tanggal_laporan', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->nama_kecamatan = $row->cariWilayahKerja->cariKecamatan->nama_kecamatan;
            $row->wilayah_kerja = $row->cariWilayahKerja->nama_daerah;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->tanggal_laporan = date('d F Y', strtotime($row->tanggal_laporan));
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    //CRUD

    public function update(Request $request, $id)
    {
        $rows = Laporan::find($id);

        $fillAble = (new Laporan())->getFillable();
        $rows->update($request->only($fillAble));

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Laporan())->getFillable();
        Laporan::create($request->only($fillAble));

        return redirect($this->page);
    }

    public function destroy($id)
    {
        $rows = Laporan::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
