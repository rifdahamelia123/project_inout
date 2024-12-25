@extends('layouts.app')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Barang Keluar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Log Barang Keluar</div>
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
                                <h4>Log Barang Keluar</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('log_keluar.export', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" class="btn btn-success">Cetak EXCEL</a>
                                </div>
                            </div>
                            <!-- Form Pilih Bulan untuk menampilkan Barang Keluar per bulan dan tahun -->
                            <div class="card-body">
                                <form action="{{ route('log_keluar.search') }}" method="GET" class="mb-4">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="bulan">Pilih Bulan dan Tahun :</label>
                                            <div class="input-group">
                                                <select name="bulan" class="form-control" id="bulan">
                                                    <option value="">Bulan</option>
                                                    <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                                                    <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                                                    <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                                                    <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                                                    <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                                                    <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                                                    <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                                                    <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                                                    <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                                                    <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                                                    <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                                                    <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                                                </select>
                                                <select name="tahun" class="form-control" id="tahun">
                                                    <option value="">Tahun</option>
                                                    @for ($i = 2024; $i <= date('Y') + 10; $i++) <!-- Ubah di sini -->
                                                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary mt-4">Tampilkan Barang Keluar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>UOM</th>
                                                <th>Stok awal</th>
                                                <th>Kuantitas Keluar</th>
                                                <th>Stok Akhir</th>
                                                <th>Nama Penerima</th>
                                                <th>Departemen</th>
                                                <th>Jabatan</th>
                                                <th>Keperluan</th>
                                                <th>Tanggal Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($barang as $barangkeluar)
                                            <tr>
                                                    <td>{{ $loop->iteration + ($barang->currentPage() - 1) * $barang->perPage() }}</td>
                                                    <td>{{ $barangkeluar->kode_barang }}</td>
                                                    <td>{{ $barangkeluar->nama_barang }}</td>
                                                    <td>{{ $barangkeluar->uom }}</td>
                                                    <td>{{ $barangkeluar->stok }}</td>
                                                    <td>{{ $barangkeluar->keluar }}</td>
                                                    <td>{{ $barangkeluar->stok_akhir }}</td>
                                                    <td>{{ $barangkeluar->nama_penerima }}</td>
                                                    <td>{{ $barangkeluar->departemen }}</td>
                                                    <td>{{ $barangkeluar->jabatan }}</td>
                                                    <td>{{ $barangkeluar->keperluan }}</td>
                                                    <td>{{ $barangkeluar->created_at }}</td>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
        </section>
    </div>
@endsection
