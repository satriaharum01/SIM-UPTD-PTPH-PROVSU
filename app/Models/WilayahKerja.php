<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKerja extends Model
{
    use HasFactory;
    protected $table = 'wilayah_kerja';
    protected $primaryKey = 'id';
    protected $fillable = ['kecamatan_id','nama_daerah'];

}
