<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $fillable = ['kabupaten_id','nama_kecamatan'];
    protected $inputType = [
        'kabupaten_id' => 'select',
        'nama_kecamatan' => 'text'
    ];

    public function getField()
    {
        return $this->inputType;
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
}
