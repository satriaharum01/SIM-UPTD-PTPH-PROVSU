<?php

// app/Http/Controllers/AnimeController.php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        // Mengambil semua data anime
        $animes = Anime::all();
        return response()->json($animes);
    }

    public function show($id)
    {
        // Mengambil data anime berdasarkan ID
        $anime = Anime::find($id);
        if ($anime) {
            return response()->json($anime);
        } else {
            return response()->json(['message' => 'Anime not found'], 404);
        }
    }
}
