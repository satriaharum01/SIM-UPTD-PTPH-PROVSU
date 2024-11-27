<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Billing;
use App\Models\Doctors;
use App\Models\MedicalRecords;
use App\Models\Patients;
use App\Models\Prescriptions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class LoginDoctor extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_dokter');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->data['title'] = 'Dashboard Dokter';
        $this->data['c_patients'] = $this->count_doctor_patients();
        $this->data['c_records'] = $this->count_record_doctors();
        $this->data['c_appointments'] = $this->count_doctor_appointments();

        $this->data['chart'] = $this->graph_area();
        return view('dokter/dashboard/index', $this->data);
    }

    public function appointments()
    {
        $this->data['title'] = 'Data Appointment';
        $this->data[ 'link' ] = '/dokter/appointment';
        $this->data['page'] = 'dokter/appointment';
        $this->view = 'dokter/appointment/index';
        return view($this->view, $this->data);
    }

    public function patients()
    {
        $this->data['title'] = 'Data Pasien';
        $this->data[ 'link' ] = '/dokter/pasien';
        $this->data['page'] = 'dokter/pasien';
        $this->view = 'dokter/pasien/index';
        return view($this->view, $this->data);
    }
    public function patients_diagnose($id)
    {
        $this->data['title'] = 'Data Diagnosis dan Resep Pasien';
        $this->data[ 'link' ] = '/dokter/pasien/record/'.$id;
        $this->data['page'] = 'dokter/pasien/record/'.$id;
        $this->data['load'] = Patients::find($id);
        $this->view = 'dokter/pasien/diagnose';
        return view($this->view, $this->data);
    }
    public function medical_records()
    {
        $this->data['title'] = 'Data Rekam Medis Pasien';
        $this->data[ 'link' ] = '/dokter/medical';
        $this->data['page'] = 'dokter/medical';
        $this->view = 'dokter/medical/index';
        return view($this->view, $this->data);
    }

    public function prescriptions()
    {
        $this->data['title'] = 'Data Obat/Resep';
        $this->data[ 'link' ] = '/dokter/prescriptions';
        $this->data['page'] = 'dokter/prescriptions';
        $this->view = 'dokter/prescriptions/index';
        return view($this->view, $this->data);
    }


    //COUNTERS
    public function count_doctor_patients()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        $app = Appointments::select('patient_id')
                ->where('doctor_id', $doctor->id)
                ->get()->toArray();
        $data = Patients::select('*')
                ->whereIn('id', $app)
                ->count();

        return $data;
    }

    public function count_record_doctors()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();
        $data = MedicalRecords::select('*')
                ->where('doctor_id', $doctor->id)
                ->count();

        return $data;
    }

    public function count_doctor_appointments()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        $data = Appointments::select('patient_id')
                ->where('doctor_id', $doctor->id)
                ->count();

        return $data;
    }

    //GRAPH
    public function graph_area()
    {
        $out = array();
        $date = date('Y-');
        for ($i = 1; $i <= 12 ; $i++) {
            if ($i < 10) {
                $finder = $date.'0'.$i;
            } else {
                $finder = $date.$i;
            }
            $data = Appointments::select('*')->where('created_at', '>=', $finder.'-00')->where('created_at', '<=', $finder.'-31')->get();
            $result = 0;
            $out[] = $result;
        }

        return json_encode($out);
    }
}
