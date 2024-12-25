<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini
use App\Exports\LogMasukExport;

class LogMasukController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dan tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query untuk mengambil data barang masuk dengan pagination
        $query = BarangMasuk::query();

        // Jika bulan dan tahun diisi, filter data
        if ($bulan && $tahun) {
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }

        // Ambil data barang masuk dengan pagination (7 item per halaman)
        $barang = $query->paginate(7);

        return view('pages.log.logmasuk', compact('barang'));
    }

    public function search(Request $request)
    {
        // Ambil bulan dan tahun dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query untuk mengambil data barang masuk
        $query = BarangMasuk::query();

        // Jika bulan dan tahun diisi, filter data
        if ($bulan && $tahun) {
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }

        // Ambil data barang masuk dengan pagination (7 item per halaman)
        $barang = $query->paginate(7); // Ubah ini untuk menggunakan paginate()

        return view('pages.log.logmasuk', compact('barang', 'bulan', 'tahun'));
    }

    public function export(Request $request)
    {
        $bulan = $request->input('bulan'); // Ambil bulan dari input form
        $tahun = $request->input('tahun'); // Ambil tahun dari input form

        // Log untuk memastikan bulan dan tahun yang diterima
        \Log::info("Exporting log masuk data for month: $bulan, year: $tahun");

        return Excel::download(new LogMasukExport($bulan, $tahun), 'log_masuk.xlsx');
    }
}
