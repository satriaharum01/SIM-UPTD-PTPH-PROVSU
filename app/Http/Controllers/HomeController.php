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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = env('APP_NAME');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('landing/index', $this->data);
    }

    public function login()
    {
        $this->data['alertMessage'] = '';
        return view('auth/login', $this->data);
    }

    public function get_doctors()
    {
        $data = Doctors::select('*')
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_patients()
    {
        $data = Patients::select('*')
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_appointments()
    {
        $data = Appointments::select('*')
        ->orderby('appointment_date', 'DESC')
        ->orderby('appointment_time', 'DESC')
        ->get();

        foreach ($data as $row) {
            $row->waktu = date('d F Y', strtotime($row->appointment_date)) .' '. date('h:i A', strtotime($row->appointment_time));
            $row->kode = date('Ymd', strtotime($row->appointment_date)).'APPR'.$row->id;
            $row->dokter = $row->cari_dokter->name;
            $row->pasien = $row->cari_pasien->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_patients_appointments($id)
    {
        $data = Appointments::select('*')
        ->where('patient_id', $id)
        ->orderby('appointment_date', 'DESC')
        ->orderby('appointment_time', 'DESC')
        ->get();

        foreach ($data as $row) {
            $row->waktu = date('d F Y', strtotime($row->appointment_date)) .' '. date('h:i A', strtotime($row->appointment_time));
            $row->kode = date('Ymd', strtotime($row->appointment_date)).'APPR'.$row->appointment_id;
            $row->dokter = $row->cari_dokter->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_doctor_appointments()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();
        $data = Appointments::select('*')
        ->where('doctor_id', $doctor->id)
        ->orderby('appointment_date', 'DESC')
        ->orderby('appointment_time', 'DESC')
        ->get();

        foreach ($data as $row) {
            $row->waktu = date('d F Y', strtotime($row->appointment_date)) .' '. date('h:i A', strtotime($row->appointment_time));
            $row->kode = date('Ymd', strtotime($row->appointment_date)).'APPR'.$row->appointment_id;
            $row->pasien = $row->cari_pasien->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
