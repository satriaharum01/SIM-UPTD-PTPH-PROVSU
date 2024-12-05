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
    protected $inputType = [
        'petugas_id' => 'select',
        'wilayah_kerja_id' => 'select',
        'tanaman_id'  => 'select',
        'opt_id' =>  'select',
        'luas_terserang' => 'number',
        'tingkat_kerusakan' => 'select',
        'tanggal_laporan' => 'date',
        'keterangan' => 'textarea'
    ];

    
    public function getField()
    {
        return $this->inputType;
    }
}
