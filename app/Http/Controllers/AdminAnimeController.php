<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use Models
use App\Models\Anime;
use App\Models\Episode;
use Yajra\DataTables\Facades\DataTables;

class AdminAnimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('is_admin');
    }

    public function index()
    {
        $this->data['title'] = 'Anime Management';
        $this->data['sub_title'] = 'List Anime '.env('APP_NAME');
        $this->data['animes'] = Anime::orderBy('title')->paginate(10);

        return view('admin/anime/index', $this->data);
    }

    public function show($id)
    {
        $anime = Anime::findorfail($id);
        $this->data['title'] = 'Anime Management';
        $this->data['anime'] = $anime;
        $this->data['sub_title'] = $anime->title;

        return view('admin/anime/show', $this->data);
    }
    public function new()
    {
        $this->data['title'] = 'Anime Management';
        $this->data['sub_title'] = 'Add New Anime ';

        return view('admin/anime/detail', $this->data);
    }

    public function json($id)
    {
        $data = Episode::select('*')
                ->where('anime_id', $id)
                ->orderby('title', 'ASC')
                ->get();
        
        foreach($data as $row)
        {
            $row->episode = $row->title;
            $row->replies = 1;
            $row->date_updated = date('d F, Y', strtotime($row->updated_at));
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
