<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

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

        try {
            // Simpan ke database
            Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'ukuran' => $request->ukuran,
                'satuan' => $request->satuan,
                'concatenate_c_and_d' => $concatenate,
                'upper_description' => $upperDescription,
                'upper_uom' => $upperUom,
                'stok' => $request->stok,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
        } catch (QueryException $e) {
            // Menangkap pelanggaran constraint unik
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('error', 'Kode barang atau nama barang sudah ada sebelumnya.');
            }

            // Menangkap kesalahan lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan barang.');
        }
    }


    public function edit($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        return view('pages.barang.edit', compact('barang'));
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
        ]);

        // Menghasilkan concatenate, upper_description, dan upper_uom secara otomatis
        $concatenate = $request->nama_barang . ' ' . $request->ukuran;
        $upperDescription = strtoupper($concatenate);
        $upperUom = strtoupper($request->satuan);

        $barang = Barang::find($id);
        if ($barang) {
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
            ]);

            return redirect()->route('barang.index')->with('success', 'Barang berhasil diedit');
        } else {
            return back()->with('error', 'Barang tidak ditemukan');
        }
    }



    public function destroy($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang Berhasil di Hapus');
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

    return view('pages.barang.index', compact('barang'));
    }
    

    public function import()
    {
        return view('pages.barang.import');
    }


}
