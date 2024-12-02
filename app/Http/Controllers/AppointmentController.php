<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Models\Appointments;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Appointment';
        $this->data[ 'link' ] = '/admin/appointment';
        $this->page = 'admin/appointment';
        $this->view = 'admin/appointment/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = Appointments::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }

    public function update(Request $request, $id)
    {
        $rows = Appointments::find($id);

        $rows->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes,
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function store(Request $request)
    {
        Appointments::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect($this->page);
    }

    public function json()
    {
        $data = Appointments::select('*')
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
