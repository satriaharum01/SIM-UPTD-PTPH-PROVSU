<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Auth;
use App\Models\MedicalRecords;
use App\Models\Doctors;

class DoctorMedicalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Rekam Medis';
        $this->data[ 'link' ] = '/dokter/medical';
        $this->page = 'dokter/medical';
        $this->view = 'dokter/medical/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = MedicalRecords::findOrFail($id);
        $rows->delete();
        return redirect($this->page);

    }


    public function store(Request $request)
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        MedicalRecords::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'visit_date' => $request->visit_date
         ]);

        return redirect($this->page);
    }

    public function update(Request $request, $id)
    {
        $rows = MedicalRecords::find($id);

        $rows->update([
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'visit_date' => $request->visit_date,
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function json()
    {
        $doctor = Doctors::select('id')->where('user_id', Auth::user()->id)->first();

        $data = MedicalRecords::select('*')
                ->where('doctor_id', $doctor->id)
                ->orderby('visit_date', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->pasien = $row->cari_pasien->name;
            $row->waktu = date('d F Y', strtotime($row->visit_date));
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = MedicalRecords::select('*')->where('id', $id)->first();
        $data->pasien = $data->cari_pasien->name;

        return json_encode($data);
    }

}
