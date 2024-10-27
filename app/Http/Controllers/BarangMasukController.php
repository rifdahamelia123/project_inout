<?php

namespace App\Http\Controllers;

use App\Exports\BarangMasukExport;
use App\Models\BarangMasuk;
use App\Imports\BarangMasukImport;
use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangMasukController extends Controller
{

    public function index(Request $request)
    {
        $bulan = $request->input('bulan'); // Mendapatkan input bulan dari form

        if ($bulan) {
            // Jika bulan dipilih, ambil data berdasarkan bulan dan tahun
            $barangMasuk = BarangMasuk::whereMonth('tanggal', '=', date('m', strtotime($bulan)))
                ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
                ->paginate(7);
        } else {
            // Jika tidak ada bulan dipilih, tampilkan semua data
            $barangMasuk = BarangMasuk::paginate(7);
        }

        return view('pages.barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        // Menampilkan form untuk menambah barang masuk
        return view('pages.barang_masuk.create');
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
        ]);

        // Simpan data barang masuk
        BarangMasuk::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'uom' => $request->uom,
            'kuantitas' => $request->kuantitas,
            'tanggal' => $request->tanggal,
            'nama_penerima' => $request->nama_penerima,
            'departemen' => $request->departemen,
            'tipe' => 'masuk', 
        ]);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit($kode_barang)
    {
        // Cari data barang masuk berdasarkan kode_barang
        $item_masuk = BarangMasuk::where('kode_barang', $kode_barang)->first();
    
        // Pastikan variabel dikirim ke view
        return view('pages.barang_masuk.edit', compact('item_masuk'));
    }
    
    public function tambah($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('barang_masuk.tambah', compact('barang'));
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
            'nama_penerima' => 'required|date',
            'departemen' => 'required|date',
        ]);

        // Update data barang masuk
        $barangMasuk = Barang::findOrFail($id);
        $barangMasuk->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'uom' => $request->uom,
            'kuantitas' => $request->kuantitas,
            'tanggal' => $request->tanggal,
            'nama_penerima' => $request->nama_penerima,
            'departemen' => $request->departmen,
            
        ]);

        return redirect()->route('barangMasuk.index')->with('success', 'Barang masuk berhasil diupdate');
    }

    public function destroy($id)
    {
        // Hapus data barang masuk
        $barangMasuk = Barang::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('barangMasuk.index')->with('success', 'Barang masuk berhasil dihapus');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');

        // Cari barang di tabel BarangKeluar
        $barangMasuk = BarangMasuk::where('kode_barang', 'LIKE', "%{$query}%")
            ->orWhere('nama_barang', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('pages.barang_masuk.index', compact('barangMasuk'));
    }

    public function import()
    {
        return view('pages.barang_masuk.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new BarangMasukImport, $request->file('file_excel'));

        return redirect()->route('barang_masuk.index')->with('success', 'Import Data Sukses');
    }

    public function export(Request $request)
    {
        $bulan = $request->input('bulan'); // Ambil bulan dari input form
        return Excel::download(new BarangMasukExport($bulan), 'barang_masuk.xlsx');
    }

}