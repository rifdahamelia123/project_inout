<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\DashboardInout;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DashboardInoutImport;
use App\Exports\DashboardInoutExport;



class DashboardInoutController extends Controller
{
    public function index()
    {
        // Ambil data dari model atau tabel terkait
        $dashboardInout =  Barang::paginate(10);

          // Atau sesuai dengan model/tabel yang digunakan

        // Kirim data ke view
        return view('pages.app.dashboard-inout', [
            'barang' => $dashboardInout,
        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,csv',  // Validasi file Excel
        ]);

        // Proses data excel menggunakan Maatwebsite\Excel dan DashboardInoutImport
        try {
            Excel::import(new DashboardInoutImport, $request->file('file_excel'));  // Import data
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }

        return redirect()->route('dashboard-inout.index')->with('success', 'Data berhasil diimpor!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $query = $request->input('search'); // Pastikan input yang diambil sesuai dengan nama input di form

        $barang = Barang::where('kode_barang', 'LIKE', "%{$query}%")
                    ->orWhere('nama_barang', 'LIKE', "%{$query}%")
                    ->paginate(7);

        $barang->appends(['search' => $query]);

        return view('pages.app.dashboard-inout', compact('barang'));
    }



    public function import()
    {
        // Logic untuk import file Excel
        return view('pages.dashboard-inout.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new DashboardInoutImport, $request->file('file_excel'));

        return redirect()->route('dashboard-inout.index')->with('success', 'Import Data Sukses');
    }
    public function export()
    {
        return Excel::download(new DashboardInoutExport, 'dashboard_inout.xlsx');
    }

}
