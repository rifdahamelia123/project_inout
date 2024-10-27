<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\DashboardSimpadu;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DashboardSimpaduImport;
use App\Exports\DashboardSimpaduExport;



class DashboardSimpaduController extends Controller
{
    public function index()
    {
        // Ambil data dari model atau tabel terkait
        $dashboardSimpadu = DashboardSimpadu::all();  // Atau sesuai dengan model/tabel yang digunakan
    
        // Kirim data ke view
        return view('pages.dashboard-simpadu.index', compact('dashboardSimpadu'));
    }
    

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,csv',  // Validasi file Excel
        ]);
    
        // Proses data excel menggunakan Maatwebsite\Excel dan DashboardSimpaduImport
        try {
            Excel::import(new DashboardSimpaduImport, $request->file('file_excel'));  // Import data
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    
        return redirect()->route('dashboard-simpadu.index')->with('success', 'Data berhasil diimpor!');
    }
    
    public function search(Request $request)
    {
            // Validasi input
            $request->validate([
                'query' => 'required|string',
            ]);
    
            $query = $request->input('query');

            // Mencari barang berdasarkan kode_barang atau nama_barang
            $dashboardSimpadu = DashboardSimpadu::where('kode_barang', 'LIKE', "%{$query}%")
                ->orWhere('nama_barang', 'LIKE', "%{$query}%")
                ->get();
            // Return hasil pencarian ke view index.blade.php
            return view('pages.dashboard-simpadu.index', compact('dashboardSimpadu'));
    }


    public function import()
    {
        // Logic untuk import file Excel
        return view('pages.dashboard-simpadu.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        // Sesuaikan dengan class DashboardSimpaduImport yang benar
        Excel::import(new DashboardSimpaduImport, $request->file('file_excel'));

        return redirect()->route('dashboard-simpadu.index')->with('success', 'Import Data Sukses');
    }
    public function export()
    {
        return Excel::download(new DashboardSimpaduExport, 'dashboard_simpadu.xlsx');
    }

}
