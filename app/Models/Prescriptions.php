<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    use HasFactory;
    protected $table = 'prescriptions';
    protected $primaryKey = 'id';
    protected $fillable = ['appointment_id','medication','dosage','instructions'];

    public function cari_appointment()
    {
        return $this->belongsTo('App\Models\Appointments', 'appointment_id', 'id')->withDefault([
            'patient_id'  => '0',
            'doctor_id'  => '0',
            'appointment_date'  => null,
            'appointment_time' => null,
            'status'  => null,
            'notes'  => null
        ]);
    }
}
