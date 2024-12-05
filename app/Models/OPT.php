<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPT extends Model
{
    use HasFactory;
    protected $table = 'opt';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_opt','deskripsi'];
    protected $inputType = [
        'nama_opt' => 'text',
        'deskripsi' => 'textarea'
    ];

    
    public function getField()
    {
        return $this->inputType;
    }
}
