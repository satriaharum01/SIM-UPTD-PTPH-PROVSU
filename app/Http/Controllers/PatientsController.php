<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Models\Patients;

class PatientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Pasien';
        $this->data[ 'link' ] = '/admin/Pasien';
        $this->page = 'admin/pasien';
        $this->view = 'admin/dokter/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = Patients::findOrFail($id);
        $rows->delete();
        return redirect($this->page);

    }

    public function update(Request $request, $id)
    {
        $rows = Patients::find($id);

        $rows->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function store(Request $request)
    {
        Patients::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth
        ]);

        return redirect($this->page);
    }

    public function json()
    {
        $data = Patients::select('*')
                ->orderby('name', 'ASC')
                ->get();

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
