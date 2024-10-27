@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Barang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Barang</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Barang</h4>
                                <div class="card-header-action d-flex justify-content-between align-items-center">
                                <a href="{{ route ('barang.import')}}" class="btn btn-primary me-2">IMPORT EXCEL</a>
                                <a href="{{ route('barang.create') }}" class="btn btn-primary me-2">Tambah Barang</a>
                                <form action="{{ route('barang.search') }}" method="GET" class="d-flex">
                                    <input type="text" class="form-control me-2" name="query" placeholder="Cari Barang" required style="width: 100px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> <!-- Ikon pencarian -->
                                    </button>
                                </form>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Ukuran</th>
                                            <th>UOM</th>
                                            <th>Concatenate C&D</th> 
                                            <th>Upper Description</th>
                                            <th>Upper UOM</th>
                                            <th>Stok</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barang as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + ($barang->currentPage() - 1) * $barang->perPage() }}</td>
                                                <td>{{ $item->kode_barang }}</td>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->ukuran }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>{{ $item->concatenate_c_and_d }}</td> 
                                                <td>{{ strtoupper($item->upper_description) }}</td>
                                                <td>{{ strtoupper($item->upper_uom) }}</td> 
                                                <td>{{ $item->stok }}</td>
                                                <td>{{ $item->tanggal }}</td>
                                                <td>
                                                    <a href="{{ route('barang.edit', $item->kode_barang) }}" class="btn btn-sm btn-info btn-icon">
                                                    <i class="fas fa-edit"></i> edit </a>
                                                    <form action="{{ route('barang.destroy', $item->kode_barang) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger btn-icon confirm-delete" onclick="return confirm('Apakah kamu yakin ingin menghapus barang ini?')">
                                                        <i class="fas fa-times"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                    <!-- Menampilkan pagination -->
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            Menampilkan {{ $barang->firstItem() }} sampai {{ $barang->lastItem() }} dari {{ $barang->total() }} data
                                        </div>
                                        <div>
                                            {{ $barang->links() }} <!-- Pagination controls -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
