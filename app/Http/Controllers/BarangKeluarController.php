<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Models\BarangKeluar; 
use App\Models\Barang;
use App\Imports\BarangKeluarImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan'); // Mendapatkan input bulan dari form

        if ($bulan) {
            // Jika bulan dipilih, ambil data berdasarkan bulan dan tahun
            $barangKeluar = BarangKeluar::whereMonth('tanggal', '=', date('m', strtotime($bulan)))
                ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
                ->paginate(7);
        } else {
            // Jika tidak ada bulan dipilih, tampilkan semua data
            $barangKeluar = BarangKeluar::paginate(7);
        }

        return view('pages.barang_keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        // Menampilkan form untuk menambah barang masuk
        return view('pages.barang_keluar.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'uom' => 'required|string',
            'kuantitas' => 'required|integer',
            'tanggal' => 'required|date',
            'nama_penerima' => 'required|string',
            'departemen' => 'required|string',
            'jabatan' => 'required|string',
            'keperluan' => 'required|string',

        ]);

        // Simpan data barang masuk
        BarangKeluar::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'uom' => $request->uom,
            'kuantitas' => $request->kuantitas,
            'tanggal' => $request->tanggal,
            'nama_penerima' => $request->nama_penerima,
            'departemen' => $request->departemen,
            'jabatan' => $request->jabatan,
            'keperluan' => $request->keperluan,
            'tipe' => 'keluar', 
        ]);

        return redirect()->route('barang_keluar.index')->with('success', 'Barang berhasil dikeluarkan!');
    }

    public function edit($kode_barang)
    {
        // Cari data barang masuk berdasarkan kode_barang
        $item_keluar = BarangKeluar::where('kode_barang', $kode_barang)->first();
    
        // Pastikan variabel dikirim ke view
        return view('pages.barang_keluar.edit', compact('item_keluar'));
    }
    

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'uom' => 'required|string',
            'kuantitas' => 'required|integer',
            'tanggal' => 'required|date',
            'nama_penerima' => 'required|string',
            'departemen' => 'required|string',
            'jabatan' => 'required|string',
            'keperluan' => 'required|string',
        ]);

        // Update data barang keluar
        $barangKeluar = Barang::findOrFail($id);
        $barangKeluar->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'uom' => $request->uom,
            'kuantitas' => $request->kuantitas,
            'tanggal' => $request->tanggal,
            'nama_penerima' => $request->nama_penerima,
            'departemen' => $request->departemen,
            'jabatan' => $request->jabatan,
            'keperluan' => $request->keperluan,
        ]);

        return redirect()->route('barangKeluar.index')->with('success', 'Barang keluar berhasil diupdate');
    }

    public function destroy($id)
    {
        // Hapus data barang masuk
        $barangKeluar = Barangkeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('barangKeluar.index')->with('success', 'Barang keluar berhasil dihapus');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');

        // Cari barang di tabel BarangKeluar
        $barangKeluar = BarangKeluar::where('kode_barang', 'LIKE', "%{$query}%")
            ->orWhere('nama_barang', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('pages.barang_keluar.index', compact('barangKeluar'));
    }


    public function import()
    {
        return view('pages.barang_keluar.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new BarangKeluarImport, $request->file('file_excel'));

        return redirect()->route('barang_keluar.index')->with('success', 'Import Data Sukses');
    }

    public function export(Request $request)
    {
        $bulan = $request->input('bulan'); // Ambil bulan dari input form
        return Excel::download(new BarangKeluarExport($bulan), 'barang_keluar.xlsx');
    }

    
}
    