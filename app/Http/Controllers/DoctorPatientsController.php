<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
use App\Models\Appointments;
use App\Models\Billing;
use App\Models\Doctors;
use App\Models\MedicalRecords;
use App\Models\Patients;
use App\Models\Prescriptions;

class DoctorPatientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Pasien';
        $this->data[ 'link' ] = '/dokter/Pasien';
        $this->page = 'dokter/pasien';
        $this->view = 'dokter/pasien/index';
        $this->data['page'] = $this->page;
    }


    public function json()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        $app = Appointments::select('patient_id')
                ->where('doctor_id', $doctor->id)
                ->get()->toArray();
        $data = Patients::select('*')
                ->whereIn('id', $app)
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function medical_json($id)
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        $data = MedicalRecords::select('*')
                ->where('patient_id', $id)
                ->where('doctor_id', $doctor->id)
                ->get();

        foreach ($data as $row) {
            $row->waktu = date('d F Y', strtotime($row->visit_date));
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function diagnose_json($id)
    {
        $app = Appointments::select('patient_id')
                ->where('patient_id', $id)
                ->get()->toArray();

        $data = Prescriptions::select('*')
                ->whereIn('appointment_id', $app)
                ->orderby('created_at', 'ASC')
                ->get();

        foreach ($data as $row) {
            $row->kode = date('Ymd', strtotime($row->cari_appointment->appointment_date)).'APPR'.$row->appointment_id;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Patients::select('*')->where('id', $id)->first();

        return json_encode($data);
    }
}
