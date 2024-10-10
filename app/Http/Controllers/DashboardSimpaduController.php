<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //Barang terbanyak
        $banyak = Barang::select('nama_barang', 'stok')
        ->orderByDesc('stok')
        ->first();

        //Barang sedikit
        $sedikit = Barang::select('nama_barang', 'stok')
        ->orderBy('stok')
        ->first();

        //Jumlah barang
        $count = Barang::count();

        //Notes
        $notes = note::all();

        return view('pages.app.dashboard_simpadu', [
            'notes' => $notes,
            'banyak' => $banyak,
            'sedikit' => $sedikit,
            'count' => $count
        ]);
        //return view('pages.app.dashboard', compact('notes'));
    }
}
