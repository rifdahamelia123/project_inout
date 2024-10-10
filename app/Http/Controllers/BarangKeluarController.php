<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BarangKeluarController extends Controller
{
    public function index()
{
    $barangKeluar = Barang::all(); // Mengambil semua data dari tabel barang_keluar
    return view('pages.barang_keluar.index', compact('barangKeluar'));
    $barangKeluar = BarangKeluar::all();
    return view('pages.barang_keluar.index', compact('barangKeluar'));
}

public function create()
{
    $barang = Barang::all(); // Mengambil semua barang dari database
    return view('pages.barang_keluar.create', compact('barang'));
}


public function store(Request $request)
{
    // Validasi input

    dd('ini controller nya');
    $validatedData = $request->validate([
        'kode_barang' => 'required|string',
        'nama_barang' => 'required|string',
        'stok' => 'required|integer',
    ]);
    BarangKeluar::create([
        'kode_barang' => $barang->kode_barang,
        'nama_barang' => $barang->nama_barang,
        'stok' => $stokAwal, // stok awal sebelum pengurangan
        'keluar' => $validatedData['jumlah_keluar'],
        'stok_akhir' => $barang->stok, // stok setelah pengurangan
        'tanggal_waktu' => now(), // Simpan waktu saat barang keluar
    ]);

    // Ambil barang berdasarkan kode_barang
    $barang = Barang::where('kode_barang', $request->kode_barang)->first();

    // Cek apakah stok mencukupi
    if ($barang->stok < $validatedData['jumlah_keluar']) {
        return redirect()->back()->withErrors(['message' => 'Stok tidak mencukupi']);
    }

    // Kurangi stok barang
    $stokAwal = $barang->stok;
    $barang->stok -= $validatedData['keluar'];
    $barang->save();

    // Simpan data barang keluar ke tabel barang_keluar

     BarangKeluar::create($validatedData);

    return redirect()->route('barang_keluar.index')->with('success', 'Barang keluar berhasil dicatat.');
}


    public function edit($id)
    {
    $item_keluar= Barang::find($id);
    return view('pages.barang_keluar.edit', compact('item_keluar'));
    }

    public function kurang(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'keluar' => 'required|integer|min:1',
    ]);

    // Temukan barang berdasarkan ID
    $barang = Barang::findOrFail($id);


    // Ambil stok awal
    $stok_awal = $barang->stok;

    // Kurangi stok barang
    $barang->stok -= $validatedData['keluar'];
    $barang->save();
    // Hitung stok_akhir
    $stok_akhir = $barang->stok;

    // Simpan riwayat barang masuk ke tabel barang_masuk
    BarangKeluar::create([
        'kode_barang' => $barang->kode_barang,
        'nama_barang' => $barang->nama_barang,
        'stok' => $stok_awal, // Ini stok yang sudah diperbarui
        'keluar' => $validatedData['keluar'],
        'stok_akhir' => $stok_akhir,
        'tanggal_waktu' => now()
    ]);

        return redirect()->route('barang_keluar.index')->with('success', 'Barang berhasil dikurangi.');

}


    public function search(Request $request)
    {
    $query = $request->input('query');

    // Cari barang berdasarkan nama atau kode
    $barang = Barang::where('kode_barang', 'like', '%' . $query . '%')
        ->orWhere('nama_barang', 'like', '%' . $query . '%')
        ->get();

    return view('barang_keluar.index', compact('barang'));
    }


    public function update(Request $request, $id)
{
    // Validasi input jumlah barang keluar
    $validatedData = $request->validate([
        'keluar' => 'required|integer|min:1',
    ]);

    // Ambil data barang dari tabel Barang berdasarkan ID
    $barang = Barang::findOrFail($id);

    // Cek apakah stok mencukupi
    if ($barang->stok >= $validatedData['keluar']) {
        // Kurangi stok barang
        $barang->stok -= $validatedData['keluar'];
        $barang->save();
    } else {
        return redirect()->back()->withErrors('Stok barang tidak mencukupi.');
    }

    // Redirect kembali ke halaman barang keluar dengan pesan sukses
    return redirect()->route('barang_keluar.index')->with('success', 'Barang berhasil dikurangkan.');
}


public function destroy($id)
{
    $barangKeluar = BarangKeluar::findOrFail($id);
    $barangKeluar->delete();

    return redirect()->route('barang_keluar.index')->with('success', 'Log barang keluar berhasil dihapus.');
}


    public function riwayat()
{
    $barangKeluar = BarangKeluar::all(); // Mengambil semua data barang keluar
    return view('pages.barang_keluar.logbarangkeluar', compact('barangKeluar'));
}


    public function keluarkanBarang(Request $request)
{
    // Misalkan proses pengurangan stok sudah berjalan
    $barang = Barang::find($request->id_barang);
    $stokAwal = $barang->stok;

    // Mengurangi stok barang
    $barang->stok -= $request->jumlah_keluar;
    $barang->save();

    // Setelah barang berhasil dikeluarkan, masukkan data ke tabel barang_keluar
    $barangKeluar = new BarangKeluar();
    $barangKeluar->kode_barang = $barang->kode_barang;
    $barangKeluar->nama_barang = $barang->nama_barang;
    $barangKeluar->stok = $stokAwal;
    $barangKeluar->keluar = $request->jumlah_keluar;
    $barangKeluar->stok_akhir = $barang->stok;
    $barangKeluar->tanggal_waktu = now();  // Menyimpan waktu barang keluar
    $barangKeluar->save();

    // Redirect atau kirim response setelah barang keluar berhasil dicatat
    return redirect()->back()->with('success', 'Barang berhasil dikeluarkan dan log barang keluar telah dicatat.');
}

public function exportBarangKeluar()
    {
        return Excel::download(new BarangKeluarExport, 'log-barang-keluar.xlsx');
    }

}
