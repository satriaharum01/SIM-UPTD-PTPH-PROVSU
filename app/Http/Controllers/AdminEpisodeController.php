<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Anime;
use App\Models\Episode;
use Yajra\DataTables\Facades\DataTables;

class AdminEpisodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Anime Management';
        $this->data['sub_title'] = 'List Episode '.env('APP_NAME');

        return view('admin/episode/index', $this->data);
    }

    public function new()
    {
        $this->data['title'] = 'Anime Management';
        $this->data['sub_title'] = 'Add New Anime Episode ';

        return view('admin/episode/detail', $this->data);
    }

    public function json()
    {
        $data = Episode::select('*')
                ->orderBy('updated_at','DESC')
                ->get();
        
        foreach($data as $row)
        {
            $row->episode = $row->find_anime->title.' '.$row->title;
            $row->replies = 1;
            $row->date_updated = date('d F, Y', strtotime($row->updated_at));
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
