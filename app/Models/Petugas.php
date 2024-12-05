<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $table = 'petugas';
    protected $primaryKey = 'id';
    protected $fillable = ['kabupaten_id','user_id','wilayah_kerja_id'];
    protected $inputType = [
        'kabupaten_id' => 'select',
        'user_id' => 'select',
        'wilayah_kerja_id' => 'select'
    ];

    public function getField()
    {
        return $this->inputType;
    }

    
    public function cariUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    public function cariKabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten', 'kabupaten_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }

    
    public function cariWilayahKerja()
    {
        return $this->belongsTo('App\Models\WilayahKerja', 'wilayah_kerja_id', 'id')->withDefault(function ($data) {
            if (collect($data->getFillable())->every(fn($attr) => $data->$attr === null)) {
                return null;
            }
            return $data;
        });
    }
}
