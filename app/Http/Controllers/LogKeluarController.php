<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;

class LogKeluarController extends Controller
{
    public function index()
{
    $barang = BarangKeluar::all(); 
    return view('pages.log.logKeluar', compact('barang')); 
}

}
