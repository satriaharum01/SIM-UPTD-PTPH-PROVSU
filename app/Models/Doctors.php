<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $primaryKey = 'id';
    protected $fillable = ['name','specialization','phone_number','user_id'];

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->withDefault([
            'name' => null,
            'email' => null
        ]);
    }
}
