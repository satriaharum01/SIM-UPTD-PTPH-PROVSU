<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
use App\Models\Appointments;
use App\Models\Doctors;

class DoctorAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Appointment';
        $this->data[ 'link' ] = '/dokter/appointment';
        $this->page = 'dokter/appointment';
        $this->view = 'dokter/appointment/index';
        $this->data['page'] = $this->page;
    }

    public function reject($id)
    {
        $rows = Appointments::find($id);
        $rows->update([
            'status' => 'Canceled',
            'update_at' => now()
         ]);


        return redirect($this->page);
    }

    public function confirm(Request $request, $id)
    {
        $rows = Appointments::find($id);

        $rows->update([
            'status' => 'Completed',
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function json()
    {
        $doctor = Doctors::select('id')->where('user_id',Auth::user()->id)->first();

        $data = Appointments::select('*')
                ->where('doctor_id',$doctor->id)
                ->orderby('appointment_date', 'DESC')
                ->orderby('appointment_time', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->waktu = date('d F Y', strtotime($row->appointment_date)) .' '. date('h:i A', strtotime($row->appointment_time));
            $row->pasien = $row->cari_pasien->name;
            $row->dokter = $row->cari_dokter->name;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Appointments::select('*')->where('id', $id)->first();

        return json_encode($data);
    }

}
