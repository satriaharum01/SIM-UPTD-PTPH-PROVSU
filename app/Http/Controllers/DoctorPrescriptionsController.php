<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
use App\Models\Doctors;
use App\Models\Appointments;
use App\Models\Prescriptions;

class DoctorPrescriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Obat/Resep';
        $this->data[ 'link' ] = '/dokter/prescriptions';
        $this->page = 'dokter/prescriptions';
        $this->view = 'dokter/prescriptions/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = Prescriptions::findOrFail($id);
        $rows->delete();
        return redirect($this->page);

    }

    public function update(Request $request, $id)
    {
        $rows = Prescriptions::find($id);

        $rows->update([
            'appointment_id' => $request->appointment_id,
            'medication' => $request->medication,
            'dosage' => $request->dosage,
            'instructions' => $request->instructions,
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function store(Request $request)
    {
        Prescriptions::create([
            'appointment_id' => $request->appointment_id,
            'medication' => $request->medication,
            'dosage' => $request->dosage,
            'instructions' => $request->instructions
        ]);

        return redirect($this->page);
    }

    public function json()
    {

        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();
        $app = Appointments::select('patient_id')
                ->where('doctor_id', $doctor->id)
                ->get()->toArray();

        $data = Prescriptions::select('*')
                ->whereIn('appointment_id', $app)
                ->orderby('created_at', 'DESC')
                ->get();
        foreach ($data as $row) {
            $row->kode = date('Ymd', strtotime($row->cari_appointment->appointment_date)).'APPR'.$row->appointment_id;
            $row->pasien = $row->cari_appointment->cari_pasien->name;
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Prescriptions::select('*')->where('id', $id)->first();
        $data->kode = date('Ymd', strtotime($data->cari_appointment->appointment_date)).'APPR'.$data->appointment_id;
        $data->pasien = $data->cari_appointment->cari_pasien->name;

        return json_encode($data);
    }

}
