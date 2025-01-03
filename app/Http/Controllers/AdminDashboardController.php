<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\WilayahKerja;
use App\Models\Laporan;
use App\Models\Tanaman;
use App\Models\Verifikasi;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use App\Http\helpers\Formula;
use Auth;

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
        $this->data['laporan'] = $this->count_laporan_provinsi();
        $this->data['laporan_menunggu'] = $this->count_laporan_menunggu();
        $this->data['laporan_verifikasi'] = $this->count_laporan_verifikasi();
        $this->data['kabupaten'] = $this->count_kabupaten();
        $this->data['kecamatan'] = $this->count_kecamatan();
        $this->data['wilayahKerja'] = $this->count_wilayahKerja();
        $this->data['tanaman'] = $this->count_tanaman();
        $this->data['opt'] = $this->count_opt();
        $this->data['chartValue'] = $this->barChart();
        $this->data['chartColor'] = Formula::$chartColor;

        return view('admin/dashboard/index', $this->data);
    }


    public function json()
    {
        $rekaptulasi = []; // Inisialisasi array kosong

        // Ambil data laporan dan join dengan relasi yang dibutuhkan
        $data = Laporan::whereHas('verifikasi', function ($query) {
            $query->where('status', 'diterima');
        })->with([
            'cariWilayahKerja.cariKecamatan.cariKabupaten',
            'cariOPT',
            'cariTanaman'
        ])
            ->orderBy('wilayah_kerja_id', 'ASC')
            ->orderBy('tanaman_id', 'ASC')
            ->orderBy('opt_id', 'ASC')
            ->orderBy('bulan_tahun', 'DESC')
            ->get();

        // Proses data
        foreach ($data as $row) {
            // Tambahkan informasi tambahan
            $row->nama_kabupaten = $row->cariWilayahKerja->cariKecamatan->cariKabupaten->nama_kabupaten;
            $row->jenis_opt = $row->cariOPT->nama_opt;
            $row->tanaman = $row->cariTanaman->nama_tanaman;
            $row->periode = Formula::$periode[$row->periode] . ' ' . date('F Y', strtotime($row->bulan_tahun));

            // Cari apakah data dengan kriteria yang sama sudah ada
            $key = collect($rekaptulasi)->search(function ($item) use ($row) {
                return $item->nama_kabupaten == $row->nama_kabupaten &&
                       $item->opt_id == $row->opt_id &&
                       $item->periode == $row->periode;
            });

            // Gabungkan data jika sudah ada
            if ($key !== false) {
                $rekaptulasi[$key]->r_serang += $row->r_serang;
                $rekaptulasi[$key]->s_serang += $row->s_serang;
                $rekaptulasi[$key]->b_serang += $row->b_serang;
                $rekaptulasi[$key]->p_serang += $row->p_serang;
            } else {
                // Tambahkan data baru
                $rekaptulasi[] = $row;
            }
        }

        // Format data jumlah menjadi 2 desimal
        foreach ($rekaptulasi as &$item) {
            $item->r_serang = number_format($item->r_serang, 2);
            $item->s_serang = number_format($item->s_serang, 2);
            $item->b_serang = number_format($item->b_serang, 2);
            $item->p_serang = number_format($item->p_serang, 2);
            $item->j_serang = number_format($item->r_serang + $item->s_serang + $item->b_serang + $item->p_serang, 2);
        }
        return Datatables::of($rekaptulasi)
            ->addIndexColumn()
            ->make(true);
    }


    public function barChart()
    {

        $tanaman = Tanaman::select('id', 'nama_tanaman')->get(); // Ambil id dan nama tanaman langsung

        // Query untuk data laporan
        $data = Laporan::selectRaw("
            tanaman_id,
            MONTH(CONCAT(bulan_tahun, '-01')) as bulan,
            SUM(r_serang + s_serang + b_serang + p_serang) as total_serangan
        ")
                ->whereRaw("SUBSTRING(bulan_tahun, 1, 4) = ?", [date('Y')]) // Tahun berjalan
                ->whereIn('tanaman_id', $tanaman->pluck('id')) // ID tanaman diambil dari hasil query
                ->groupBy('tanaman_id', 'bulan')
                ->orderBy('bulan', 'ASC')
                ->get();

        // Format label bulan
        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Inisialisasi array nilai untuk setiap tanaman
        $value = [];
        foreach ($tanaman as $tanam) {
            $value[$tanam->nama_tanaman] = array_fill(0, 12, 0); // Isi default 0 untuk setiap bulan
        }

        // Isi nilai total serangan berdasarkan data laporan
        foreach ($data as $row) {
            $tanam = $tanaman->firstWhere('id', $row->tanaman_id); // Cocokkan tanaman_id
            $index = $row->bulan - 1; // Konversi ke index array (0 - 11)
            $value[$tanam->nama_tanaman][$index] = $row->total_serangan;
        }
        
        // Return data yang telah diolah
        return ['labels' => $labels,'data' => $value];
    }
}
