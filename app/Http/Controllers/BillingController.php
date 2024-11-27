<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Models\Billing;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['title'] = 'Data Pembayaran';
        $this->data[ 'link' ] = '/admin/billing';
        $this->page = 'admin/billing';
        $this->view = 'admin/billing/index';
        $this->data['page'] = $this->page;
    }

    public function destroy($id)
    {
        $rows = Billing::findOrFail($id);
        $rows->delete();

        return redirect($this->page);
    }

    public function update(Request $request, $id)
    {
        $rows = Billing::find($id);

        $rows->update([
            'appointment_id' => $request->appointment_id,
            'total_amount' => $request->total_amount,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
            'update_at' => now()
         ]);

        return redirect($this->page);
    }

    public function store(Request $request)
    {
        Billing::create([
            'appointment_id' => $request->appointment_id,
            'total_amount' => $request->total_amount,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method
        ]);

        return redirect($this->page);
    }

    public function json()
    {
        $data = Billing::select('*')
                ->orderby('created_at', 'DESC')
                ->get();

        foreach ($data as $row) {
            $row->kode = date('Ymd',strtotime($row->cari_appointment->appointment_date)).'APPR'.$row->appointment_id;
            $row->jumlah = number_format($row->total_amount,0);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Billing::select('*')->where('id', $id)->first();
        $data->kode = date('Ymd',strtotime($data->cari_appointment->appointment_date)).'APPR'.$data->appointment_id;

        return json_encode($data);
    }

}
