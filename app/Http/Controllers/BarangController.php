<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('pages.barang.index', compact('barang'));
    }

    public function create()
    {
        return view('pages.barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string',
            'nama_barang' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date',
            'stok' => 'required|integer'
        ]);


        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Data created successfully');
    }

    public function edit($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        return view('pages.barang.edit', compact('barang'));
    }

    public function update(Request $request, $kode_barang)
    {
        $barangs = Barang::find($kode_barang);
        $barangs->update($request->all());
        return redirect()->route('barang.index')->with('success', 'Data Edit successfully');
        }

    public function destroy($kode_barang)
    {
        $barang = Barang::findOrFail($kode_barang);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data deleted successfully');
    }
    public function search(Request $request)
    {
    $request->validate([
        'query' => 'required|string',
    ]);

    $query = $request->input('query');

    $barang = Barang::where('kode_barang', 'LIKE', "%{$query}%")
                ->orWhere('nama_barang', 'LIKE', "%{$query}%")
                ->get();

    return view('pages.barang.index', compact('barang'));
    }

    public function barangMasuk()
    {
    // Query to get all incoming items (barang masuk)
    $barangMasuk = Barang::where('tipe', 'masuk')->get(); // Assuming you have a 'tipe' field to differentiate masuk/keluar

    return view('barang.masuk', compact('barangMasuk'));
    }

    public function import()
    {
        return view('pages.barang.import');
    }


}
