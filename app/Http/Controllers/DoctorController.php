<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Models\Doctors;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Dokter';
        $this->data[ 'link' ] = '/admin/dokter';
        $this->page = 'admin/dokter';
        $this->view = 'admin/dokter/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = Doctors::findOrFail($id);
        $rows->delete();
        return redirect($this->page);

    }

    public function update(Request $request, $id)
    {
        $rows = Doctors::find($id);

        $rows->update([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'phone_number' => $request->phone_number,
            'update_at' => now()
         ]);


        return redirect($this->page);

    }

    public function store(Request $request)
    {
        Doctors::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'phone_number' => $request->phone_number,
        ]);

        return redirect($this->page);
    }

    public function json()
    {
        $data = Doctors::select('*')
                ->orderby('name', 'ASC')
                ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Doctors::select('*')->where('id', $id)->first();

        return json_encode($data);
    }

}
