<!-- resources/views/barang_masuk/riwayat.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Riwayat Barang Masuk</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>UOM</th>
                    <th>Kuantitas</th>
                    <th>Tanggal</th>
                    <th>Nama Penerima</th>
                    <th>Departemen</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangMasuk as $barang)
                    <tr>
                        <td>{{ $barang->id }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ strtoupper($barang->uom) }}</td>
                        <td>{{ $barang->kuantitas }}</td>
                        <td>{{ $barang->tanggal }}</td>
                        <td>{{ $barang->nama_penerima }}</td>
                        <td>{{ $barang->departemen }}</td>
                        <td>{{ $barang->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
