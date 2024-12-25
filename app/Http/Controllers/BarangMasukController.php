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

    public function index()
    {
    $barangMasuk = Barang::paginate(7);
    return view('pages.barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('pages.barang_masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        // Validasi input permintaan
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|exists:barang,kode_barang',
            'kuantitas' => 'required|integer|min:1',
            'nama_penerima' => 'required|string',
            'departemen' => 'required|string',
        ]);

        // Temukan barang di tabel `barang` berdasarkan `kode_barang`
        $barang = Barang::where('kode_barang', $validatedData['kode_barang'])->first();

        $dashboardInout = $barang->dashboardInout; // Pastikan ini benar
        if (!$dashboardInout) {
            // Menangani kasus jika data dashboard tidak ada
            return redirect()->back()->withErrors('Data dashboard tidak ditemukan untuk item ini.');
        }

        // Perbarui stok di tabel `barang`
        $barang->stok += $validatedData['kuantitas'];

        // Logika untuk memperbarui Order Qty dan Remark di tabel Dashboard
        $minValue = $dashboardInout->min; // Pastikan Anda mengambil dari $dashboardInout

        if ($barang->stok < $minValue) {
            // Jika stok di bawah nilai minimum, set Order Qty dan Remark
            $dashboardInout->order_qty = $minValue - $barang->stok;
            $dashboardInout->remark = 'ORDER';
        } else {
            // Jika stok aman, set Order Qty ke 0 dan Remark ke 'Aman'
            $dashboardInout->order_qty = 0;
            $dashboardInout->remark = 'AMAN';
        }

        // Simpan perubahan
        $barang->save();
        $dashboardInout->save(); // Pastikan Anda menyimpan pada objek yang benar

        // Simpan data ke tabel `barang_masuk`
        BarangMasuk::create([
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => $barang->nama_barang,
            'uom' => $barang->satuan,
            'concatenate_c_and_d' => $barang->kode_barang . '-' . $barang->satuan,
            'stok' => $barang->stok - $validatedData['kuantitas'],
            'masuk' => $validatedData['kuantitas'],
            'stok_akhir' => $barang->stok,
            'tanggal' => now(),
            'nama_penerima' => $validatedData['nama_penerima'],
            'departemen' => $validatedData['departemen'],
        ]);

        return redirect()->route('barang_masuk.index')->with('success', 'Stok barang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        // Ambil data barang berdasarkan ID dari tabel Barang
        $item_masuk = Barang::findOrFail($id);

        // Kirim data barang ke view form untuk ditampilkan dan diedit
        return view('pages.barang_masuk.edit', compact('item_masuk'));
    }


    public function tambah(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'masuk' => 'required|integer|min:1',
        'nama_penerima' => 'required|string',
        'departemen' => 'required|string',
    ]);

    // Temukan barang berdasarkan ID
    $barang = Barang::findOrFail($id);

    // Ambil stok awal
    $stok_awal = $barang->stok;

    // Tambahkan stok barang
    $barang->stok += $validatedData['masuk'];

    // Update nilai IN pada tabel barang (menambahkan jumlah masuk ke nilai IN)
    $barang->in = $validatedData['masuk'];
    $barang->save();

    // Hitung stok akhir
    $stok_akhir = $barang->stok;

    // Concatenate dan uppercase UOM
    $concatenate = $barang->nama_barang . ' ' . $barang->ukuran;
    $upperDescription = strtoupper($concatenate);
    $upperUom = strtoupper($barang->satuan);

    // Simpan riwayat barang masuk ke tabel barang_masuk
    BarangMasuk::create([
        'kode_barang' => $barang->kode_barang,
        'nama_barang' => $barang->nama_barang,
        'uom' => $barang->satuan,
        'concatenate_c_and_d' => $concatenate,
        'upper_description' => $upperDescription,
        'upper_uom' => $upperUom,
        'stok' => $stok_awal,
        'masuk' => $validatedData['masuk'],
        'stok_akhir' => $stok_akhir,
        'nama_penerima' => $validatedData['nama_penerima'],
        'departemen' => $validatedData['departemen'],
    ]);

    return redirect()->route('barang_masuk.index')->with('success', 'Stok barang berhasil ditambahkan.');
}


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
        return redirect()->route('barang_masuk.index')->with('success', 'Stok Barang berhasil ditambahkan.');
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

        // Cari barang di tabel BarangMasuk
        $barangMasuk = Barang::where('kode_barang', 'LIKE', "%{$query}%")
            ->orWhere('nama_barang', 'LIKE', "%{$query}%")
            ->paginate(7);
        $barangMasuk->appends(['query' => $query]);

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
