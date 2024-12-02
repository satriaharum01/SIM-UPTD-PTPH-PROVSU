<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;
    protected $table = 'verifikasi';
    protected $primaryKey = 'id';
    protected $fillable = ['laporan_id','verifikator_id','status','catatan','tanggal_verifikasi'];

}
