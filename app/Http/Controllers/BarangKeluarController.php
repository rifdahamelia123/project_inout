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
             $barangKeluar = Barang::whereMonth('tanggal', '=', date('m', strtotime($bulan)))
                 ->whereYear('tanggal', '=', date('Y', strtotime($bulan)))
                 ->paginate(7);
         } else {
             // Jika tidak ada bulan dipilih, tampilkan semua data
             $barangKeluar = Barang::paginate(7);
         }

         return view('pages.barang_keluar.index', compact('barangKeluar'));
     }

     public function create()
     {
         $barang = Barang::all();
         return view('pages.barang_keluar.create', compact('barang'));
     }

     public function store(Request $request)
     {
         // Validate the request input
         $validatedData = $request->validate([
             'kode_barang' => 'required|string|exists:barang,kode_barang',
             'keluar' => 'required|integer|min:1',
             'nama_penerima' => 'required|string',
             'departemen' => 'required|string',
             'jabatan'    => 'required|string',
             'keperluan'  => 'required|string',
         ]);

         // Find the item in the `barang` table based on `kode_barang`
         $barang = Barang::where('kode_barang', $validatedData['kode_barang'])->first();
         $stokAwal = $barang->stok;

         if ($stokAwal < $validatedData['keluar']) {
            return redirect()->back()->withErrors(['message' => 'Stok tidak mencukupi']);
        }

         // Update the stock in the `barang` table
         $barang->stok -= $validatedData['keluar'];
          // Logika untuk memperbarui Order Qty dan Remark di tabel Dashboard
        $minValue = $barang->dashboard->min;

        if ($barang->stok < $minValue) {
            // Jika stok di bawah nilai minimum, set Order Qty dan Remark
            $barang->dashboard->order_qty = $minValue - $barang->stok;
            $barang->dashboard->remark = 'Order';
        } else {
            // Jika stok aman, set Order Qty ke 0 dan Remark ke 'Aman'
            $barang->dashboard->order_qty = 0;
            $barang->dashboard->remark = 'AMAN';
        }
         $barang->save();
         $barang->dashboard->save();

         // Save the data into the `barang_keluar` table
         BarangKeluar::create([
             'kode_barang' => $barang->kode_barang,
             'nama_barang' => $barang->nama_barang,
             'uom' => $barang->satuan,
             'concatenate_c_and_d' => $barang->kode_barang . '-' . $barang->satuan,
             'stok' => $stokAwal,
             'keluar' => $validatedData['keluar'],
             'stok_akhir' => $barang->stok,
             'tanggal' => now(),
             'nama_penerima' => $validatedData['nama_penerima'],
             'departemen' => $validatedData['departemen'],
             'jabatan'    =>  $validatedData['jabatan'],
             'keperluan'  => $validatedData ['keperluan'],
         ]);

         return redirect()->route('_keluar.index')->with('success', 'Stok barang berhasil dikurangkan.');
     }

     public function edit($id)
     {
         // Ambil data barang berdasarkan ID dari tabel Barang
         $item_keluar = Barang::findOrFail($id);

         // Kirim data barang ke view form untuk ditampilkan dan diedit
         return view('pages.barang_keluar.edit', compact('item_keluar'));
     }


     public function tambah(Request $request, $id)
     {
         // Validasi input
         $validatedData = $request->validate([
             'keluar' => 'required|integer|min:1',
             'nama_penerima' => 'required|string',
             'departemen' => 'required|string',
             'jabatan'    => 'required|string',
             'keperluan'  => 'required|string',
         ]);

         // Temukan barang berdasarkan ID
         $barang = Barang::findOrFail($id);

         // Ambil stok awal
         $stok_awal = $barang->stok;
         if ($stok_awal < $validatedData['keluar']) {
             return redirect()->back()->withErrors(['message' => 'Stok tidak mencukupi']);
         }

         // Kurangkan stok barang
         $barang->stok -= $validatedData['keluar'];

         // Update nilai OUT pada tabel barang (menambahkan jumlah keluar ke nilai OUT)
         $barang->out = $validatedData['keluar'];
         $barang->save();

         // Hitung stok akhir
         $stok_akhir = $barang->stok;

         // Concatenate dan uppercase UOM
         $concatenate = $barang->nama_barang . ' ' . $barang->ukuran;
         $upperDescription = strtoupper($concatenate);
         $upperUom = strtoupper($barang->satuan);

         // Simpan riwayat barang keluar ke tabel barang_keluar
         BarangKeluar::create([
             'kode_barang' => $barang->kode_barang,
             'nama_barang' => $barang->nama_barang,
             'uom' => $barang->satuan,
             'concatenate_c_and_d' => $concatenate,
             'upper_description' => $upperDescription,
             'upper_uom' => $upperUom,
             'stok' => $stok_awal,
             'keluar' => $validatedData['keluar'],
             'stok_akhir' => $stok_akhir,
             'nama_penerima' => $validatedData['nama_penerima'],
             'departemen' => $validatedData['departemen'],
             'jabatan'    => $validatedData['jabatan'],
             'keperluan'  => $validatedData['keperluan'],
         ]);

         return redirect()->route('barang_keluar.index')->with('success', 'Stok barang berhasil dikurangkan.');
     }


     public function update(Request $request, $id)
     {
         // Validasi input jumlah barang keluar
         $validatedData = $request->validate([
             'keluar' => 'required|integer|min:1',
         ]);

         // Ambil data barang dari tabel Barang berdasarkan ID
         $barang = Barang::findOrFail($id);

         // Tambahkan jumlah barang keluar ke stok yang ada
         $barang->stok -= $validatedData['keluar'];
         $barang->save();

         // Redirect kembali ke halaman barang keluardengan pesan sukses
         return redirect()->route('barang_keluar.index')->with('success', 'Stok Barang berhasil dikurangkan.');
     }



     public function destroy($id)
     {
         // Hapus data barang keluar
         $barangkeluar = Barang::findOrFail($id);
         $barangkeluar->delete();

         return redirect()->route('barangKeluar.index')->with('success', 'Barang keluar berhasil dihapus');
     }

     public function search(Request $request)
     {
         $request->validate([
             'query' => 'required|string',
         ]);

         $query = $request->input('query');

         // Cari barang di tabel BarangKeluar
         $barangKeluar = Barang::where('kode_barang', 'LIKE', "%{$query}%")
             ->orWhere('nama_barang', 'LIKE', "%{$query}%")
             ->paginate(7);
         $barangKeluar->appends(['query' => $query]);

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
