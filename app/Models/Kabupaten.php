<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = 'kabupaten';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kabupaten'];
    protected $inputType = ['nama_kabupaten' => 'text'];

    public function getField()
    {
        return $this->inputType;
    }
}
