<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecords extends Model
{
    use HasFactory;
    protected $table = 'medical_records';
    protected $primaryKey = 'id';
    protected $fillable = ['patient_id','doctor_id','diagnosis','treatment','visit_date'];

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
