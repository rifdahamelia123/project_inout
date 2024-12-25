<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Imports\BarangImport;
use App\Imports\DashboardInoutImport;
use Illuminate\Http\Request;
use App\Models\DashboardInout;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::paginate(7);
        return view('pages.barang.index', compact('barang'));

    }

    public function create()
    {
        return view('pages.barang.create');
    }

    public function store(Request $request)
{
    // Validasi input yang dikirim melalui form
    $request->validate([
        'kode_barang' => 'required|string',
        'nama_barang' => 'required|string',
        'ukuran' => 'required|string',
        'satuan' => 'required|string',
        'stok' => 'required|integer',
        'tanggal' => 'required|date',
        'min' => 'required|integer',
        'max' => 'required|integer',
    ]);

    // Logika otomatis untuk concatenate, upper_description, dan upper_uom
    $concatenate = $request->nama_barang . ' ' . $request->ukuran;
    $upperDescription = strtoupper($concatenate);
    $upperUom = strtoupper($request->satuan);

    // Simpan ke database tabel `barang`
    $barang = Barang::create([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'ukuran' => $request->ukuran,
        'satuan' => $request->satuan,
        'concatenate_c_and_d' => $concatenate,
        'upper_description' => $upperDescription,
        'upper_uom' => $upperUom,
        'stok' => $request->stok,
        'tanggal' => $request->tanggal,
        'uom' => strtoupper($request->satuan),
        'min' => $request->min,
        'max' => $request->max,
        'in' => 0,
        'out' => 0,
    ]);

    // Update remark dan order_qty
    $this->updateRemarkAndOrderQty($barang);

    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
}



    public function edit($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        $dashboardInout = DashboardInout::where('kode_barang', $kode_barang)->first();
        return view('pages.barang.edit', compact('barang', 'dashboardInout'));
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'kode_barang' => 'required|string',
        'nama_barang' => 'required|string',
        'ukuran' => 'required|string',
        'satuan' => 'required|string',
        'stok' => 'required|integer',
        'tanggal' => 'required|date',
        'min' => 'required|integer',
        'max' => 'required|integer',
    ]);

    $barang = Barang::findOrFail($id);

    $concatenate = $request->nama_barang . ' ' . $request->ukuran;
    $upperDescription = strtoupper($concatenate);
    $upperUom = strtoupper($request->satuan);

    $barang->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'ukuran' => $request->ukuran,
        'satuan' => $request->satuan,
        'concatenate_c_and_d' => $concatenate,
        'upper_description' => $upperDescription,
        'upper_uom' => $upperUom,
        'stok' => $request->stok,
        'tanggal' => $request->tanggal,
        'min' => $request->min,
        'max' => $request->max,
        'uom' => $request->satuan,
    ]);

    $this->updateRemarkAndOrderQty($barang);

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}


public function destroy($id)
{
    $barang = Barang::find($id);

    if ($barang) {
        DashboardInout::where('kode_barang', $barang->kode_barang)->delete();
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    return redirect()->route('barang.index')->with('error', 'Barang tidak ditemukan.');
}

    public function search(Request $request)
    {
    $request->validate([
        'query' => 'required|string',
    ]);

    $query = $request->input('query');

    $barang = Barang::where('kode_barang', 'LIKE', "%{$query}%")
                ->orWhere('nama_barang', 'LIKE', "%{$query}%")
                ->paginate(7);

    $barang->appends(['query' => $query]);

    return view('pages.barang.index', compact('barang'));
    }


    public function import()
    {
        return view('pages.barang.import');
    }


    protected function updateRemarkAndOrderQty($barang)
    {
        $barang->remark = $barang->remark; // Memanggil aksesori untuk mendapatkan nilai remark
        $barang->order_qty = $barang->order_qty; // Memanggil aksesori untuk mendapatkan nilai order_qty

        // Simpan perubahan ke database
        $barang->save();
    }


    public function barangMasuk($id, $jumlah)
    {
        // Temukan barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Ambil nilai 'in' yang ada saat ini
        $inAwal = $barang->in;

        // Update stok dan kolom 'in'
        $barang->in = $inAwal + $jumlah;
        $barang->stok += $jumlah;
        // Simpan perubahan ke database
        $barang->save();

        // Update remark dan order_qty
        $this->updateRemarkAndOrderQty($barang);

        return redirect()->route('barang.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    public function barangKeluar($id, $jumlah)
    {
        $barang = Barang::findOrFail($id);
        if ($barang->stok < $jumlah)
        {
            return redirect()->route('barang.index')->with('error', 'Stok tidak mencukupi.');
        }
          // Update stok dan kolom 'out'
        $barang->out += $jumlah;
        $barang->stok -= $jumlah;
        $barang->save();
        $this->updateRemarkAndOrderQty($barang);

        return redirect()->route('barang.index')->with('success', 'Barang keluar berhasil dikurangi.');
    }


    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        DB::transaction(function () use ($request) {
            Excel::import(new BarangImport, $request->file('file'));
            Excel::import(new DashboardInoutImport, $request->file('file'));

            // Setelah import, perbarui remark dan order_qty untuk semua barang
            $barangList = Barang::all();
            foreach ($barangList as $barang) {
                $this->updateRemarkAndOrderQty($barang);
            }
        });

        return redirect()->back()->with('success', 'Data berhasil diimpor ke dua tabel.');
    }

    public function export()
    {

        return Excel::download(new DashboardInoutExport, 'dashboard_inout.xlsx');
    }


}


