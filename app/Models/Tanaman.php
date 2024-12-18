<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    use HasFactory;
    protected $table = 'tanaman';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_tanaman'];
    protected $inputType = [
        'nama_tanaman' => 'text'
    ];


    public function getField()
    {
        return $this->inputType;
    }
}
