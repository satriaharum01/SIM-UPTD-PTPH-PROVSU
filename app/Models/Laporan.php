<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    protected $fillable = ['petugas_id','wilayah_kerja_id','tanaman_id','opt_id','luas_terserang','tingkat_kerusakan','tanggal_laporan','keterangan'];

}
