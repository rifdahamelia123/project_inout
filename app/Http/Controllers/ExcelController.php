<?php

namespace App\Http\Controllers;

use App\Imports\BarangImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangKeluarImport;
use App\Imports\BarangMasukImport;

class ExcelController extends Controller
{
    public function importBarang()
    {
        Excel::import(new BarangImport, request()->file('file_excel'));

        return redirect()->route('barang.index')->with('success', 'Import Data Sukses');
    }

    public function importBarang_masuk()
    {
        Excel::import(new Barang_masukImport, request()->file('file_excel'));

        return redirect()->route('barang_masuk.index')->with('success', 'Import Data Sukses');
    }

    public function importBarang_keluar()
    {
        Excel::import(new BarangKeluarImport, request()->file('file_excel'));

        return redirect()->route('barang_keluar.index')->with('success', 'Import Data Sukses');
    }

    public function importDashboardSimpadu()
    {
        Excel::import(new BDashboardSimpaduImport, request()->file('file_excel'));

        return redirect()->route('dashboard-simpadu.index')->with('success', 'Import Data Sukses');
    }

}   
