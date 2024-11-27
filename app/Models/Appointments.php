<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $fillable = ['patient_id','doctor_id','appointment_date','appointment_time','status','notes'];

    public function cari_pasien()
    {
        return $this->belongsTo('App\Models\Patients', 'patient_id', 'id')->withDefault([
            'name' => null,
            'address' => null,
            'phone_number' => null,
            'gender' => null,
            'date_of_birth' => null
        ]);
    }

    public function cari_dokter()
    {
        return $this->belongsTo('App\Models\Doctors', 'doctor_id', 'id')->withDefault([
            'name' => null,
            'specialization' => null,
            'phone_number' => null
        ]);
    }
}
