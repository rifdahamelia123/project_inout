<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;

class LogMasukController extends Controller
{
    public function index()
    {
        $barang = BarangMasuk::all();
        return view('pages.log.logmasuk', compact('barang'));
    }
}
