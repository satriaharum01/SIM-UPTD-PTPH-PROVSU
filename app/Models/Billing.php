<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    protected $table = 'billing';
    protected $primaryKey = 'id';
    protected $fillable = ['appointment_id','total_amount','payment_status','payment_method'];

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
