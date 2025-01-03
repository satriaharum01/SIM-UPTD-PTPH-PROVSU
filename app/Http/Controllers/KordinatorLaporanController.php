<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Gallery;
use App\Models\Laporan;
use App\Models\Verifikasi;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
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
        $this->data['page'] = $this->page;
        return view('kordinator/laporan/index', $this->data);
    }

    public function show($id)
    {
        $rows = Laporan::find($id);
        $this->data['title'] = 'Data Laporan';
        $this->data['sub_title'] = 'Lihat Data ';
        $this->data['fieldTypes'] = (new Laporan())->getField();
        $this->data['load'] = $rows;
        $this->data['action'] = 'petugas/laporan/show/'.$rows->id;
        $this->data['photos'] = Gallery::where('laporan_id', $rows->id)->get();
        return view('kordinator/laporan/show', $this->data);
    }

    public function json()
    {
        $data = Laporan::select('*')
                ->orderby('bulan_tahun', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->nama_petugas = $row->cariPetugas->cariUser->name;
            $row->wilayah_kerja = $row->cariWilayahKerja->nama_daerah;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->periode = Formula::$periode[$row->periode] . ' '.date('F Y', strtotime($row->bulan_tahun));
            $row->luas_terserang = $row->r_serang + $row->s_serang + $row->b_serang + $row->p_serang;
            $verif = Verifikasi::where('laporan_id',$row->id)->whereHas('verifikator', function ($query) {
                $query->where('level', 'Kordinator Kabupaten'); // level Kordinator Kabupaten
            })->first();
            if(!empty($verif))
            {
                $row->status = ucfirst($verif->status);
            }else{
                $row->status = 'Menunggu'; 
            }
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Verifikasi::select('*')->where('laporan_id', $id)->where('verifikator_id',Auth::user()->id)->first();
        return json_encode($data);
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

    public function verifikasi(Request $request,$id)
    {
        $fillAble = (new Verifikasi())->getFillable();
        
        $data = $request->only($fillAble);
        Verifikasi::updateOrCreate(['verifikator_id'=> Auth::user()->id],$data);

        return redirect($this->page);
    }
    
    public function destroy($id)
    {
        $rows = Laporan::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }
}
