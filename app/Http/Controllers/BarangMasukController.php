<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangMasukController extends Controller
{

    public function index()
    {
    $barangMasuk = Barang::all();
    return view('pages.barang_masuk.index', compact('barangMasuk'));
    }


    // Menampilkan form untuk menambah barang masuk
    public function create()
    {
    $barang = Barang::all(); // Mengambil semua barang dari database
    return view('pages.barang_masuk.create', compact('barang'));
    }

    // Menyimpan data barang masuk ke database
    public function store(Request $request)
{
    $barang = Barang::where('kode_barang', $request->kode_barang)->first();
    $barang->stok += $request->jumlah_masuk;  // Update stok sesuai jumlah barang yang masuk
    $barang->save();

    return redirect()->route('barang_masuk.index');

        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'stok' => 'required|integer',
        ]);

        BarangMasuk::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'tanggal_waktu' => now(), // Simpan waktu saat ini
        ]);

        // Temukan barang berdasarkan kode_barang
        $barang = Barang::where('kode_barang', $validatedData['kode_barang'])->first();

        if (!$barang) {
            return redirect()->back()->with('error', 'Barang tidak ditemukan.');
        }

        // Tambahkan stok barang
        $barang->stok += $validatedData['masuk'];
        $barang->save();

        // Hitung stok akhir
        $validatedData['stok_akhir'] = $barang->stok;

        // Simpan data barang masuk ke tabel barang_masuk
        BarangMasuk::create($validatedData);

        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit barang masuk
    public function edit($id)
{
    // Ambil data barang berdasarkan ID dari tabel Barang
    $item_masuk = Barang::findOrFail($id);

    // Kirim data barang ke view form untuk ditampilkan dan diedit
    return view('pages.barang_masuk.edit', compact('item_masuk'));
}


    // Menambah stok barang masuk
    public function tambah(Request $request, $id )
    {
        // Validasi input
        $validatedData = $request->validate([
            'masuk' => 'required|integer|min:1',
        ]);

        // Temukan barang berdasarkan ID
        $barang = Barang::findOrFail($id);


        // Ambil stok awal
        $stok_awal = $barang->stok;

        // Tambahkan stok barang
        $barang->stok += $validatedData['masuk'];
        $barang->save();
        // Hitung stok_akhir
        $stok_akhir = $barang->stok;

        // Simpan riwayat barang masuk ke tabel barang_masuk
        BarangMasuk::create([
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => $barang->nama_barang,
            'stok' => $stok_awal, // Ini stok yang sudah diperbarui
            'masuk' => $validatedData['masuk'],
            'stok_akhir' => $stok_akhir, // Masukkan stok_akhir
            'tanggal_waktu' => now()
        ]);

        return redirect()->route('barang_masuk.index')->with('success', 'Stok barang berhasil ditambah.');
    }

    // Mengupdate data barang masuk
    public function update(Request $request, $id)
{
    // Validasi input jumlah barang masuk
    $validatedData = $request->validate([
        'masuk' => 'required|integer|min:1',
    ]);

    // Ambil data barang dari tabel Barang berdasarkan ID
    $barang = Barang::findOrFail($id);

    // Tambahkan jumlah barang masuk ke stok yang ada
    $barang->stok += $validatedData['masuk'];
    $barang->save();

    // Redirect kembali ke halaman barang masuk dengan pesan sukses
    return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
}


    // Menghapus data barang masuk
    public function destroy($id)
    {
        // Logika untuk menghapus data barang masuk
    }

    // Menampilkan riwayat barang masuk
    public function riwayat()
    {
        // Logika untuk menampilkan riwayat barang masuk
    }

    public function exportBarangMasuk()
    {
        return Excel::download(new BarangExport, 'log-barang-masuk.xlsx');
    }
}
