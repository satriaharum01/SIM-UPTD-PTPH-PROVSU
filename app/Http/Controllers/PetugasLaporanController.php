<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Petugas;
use App\Models\Laporan;
use App\Models\Gallery;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
use Auth;
use File;

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
        $this->data['photos'] = Gallery::where('laporan_id', 0)->get();

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
        $this->data['photos'] = Gallery::where('laporan_id', $rows->id)->get();

        return view('petugas/laporan/detail', $this->data);
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
        return view('petugas/laporan/show', $this->data);
    }

    public function json()
    {
        $petugas_id = Petugas::where('user_id', Auth::user()->id)->first();
        $data = Laporan::select('*')
                ->where('petugas_id', $petugas_id->id)
                ->orderby('bulan_tahun', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->nama_kecamatan = $row->cariWilayahKerja->cariKecamatan->nama_kecamatan;
            $row->wilayah_kerja = $row->cariWilayahKerja->nama_daerah;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->periode = Formula::$periode[$row->periode] . ' '.date('F Y', strtotime($row->bulan_tahun));
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
        Gallery::where('laporan_id', $rows->id)->delete();
        foreach ($request->file('photos') as $photo) {
            Gallery::create(['laporan_id' => $rows->id]);
            $foto = Gallery::select('*')->orderby('id', 'DESC')->first();

            $filename = $foto->id . '.jpg';
            $this->image_destroy($filename);
            $photo->storeAs('', $filename, ['disk' => 'img_upload']);
        }

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        $fillAble = (new Laporan())->getFillable();
        Laporan::create($request->only($fillAble));
        $row = Laporan::select('*')->orderby('id', 'DESC')->first();

        foreach ($request->file('photos') as $photo) {
            Gallery::create(['laporan_id' => $row->id]);
            $foto = Gallery::select('*')->orderby('id', 'DESC')->first();

            $filename = $foto->id . '.jpg';
            $this->image_destroy($filename);
            $photo->storeAs('', $filename, ['disk' => 'img_upload']);
        }

        return redirect($this->page)->with('success', 'Laporan berhasil dibuat!');
    }

    public function destroy($id)
    {
        $rows = Laporan::findOrFail($id);
        Gallery::where('laporan_id', $rows->id)->delete();
        $rows->delete();

        return redirect($this->page);
    }
}
