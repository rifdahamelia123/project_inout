@extends('layouts.app')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <style>
        /* Memberikan padding pada seluruh tabel, untuk memberikan ruang di sisi kiri dan kanan tabel */
        .table-responsive {
            padding-left: 30px; /* Padding kiri 30px */
            padding-right: 30px; /* Padding kanan 30px */
        }

        /* Menambahkan padding pada sel tabel (th dan td) agar tampilan tabel lebih rapi dan tidak terlalu mepet */
        table th, table td {
            padding: 10px 15px; /* Atur padding agar tampilan lebih ke dalam dan lebih mudah dibaca */
        }

        /* Membatasi lebar tabel dengan kontainer untuk menghindari tabel terlalu lebar di layar besar */
        .container-table {
            max-width: 1100px; /* Lebar maksimal tabel 1100px */
            margin: 0 auto; /* Membuat tabel berada di tengah-tengah halaman */
        }

        /* Mengatur ukuran font pada header utama di bagian .section-header */
        .section-header h1 {
            font-size: 24px; /* Ukuran font header utama diubah menjadi 24px */
        }

        /* Mengatur ukuran font pada judul di dalam card-header */
        .card-header h4 {
            font-size: 20px; /* Ukuran font untuk judul card-header diubah menjadi 20px */
        }

        /* Mengatur ukuran font dalam tabel, agar teks tidak terlalu besar */
        .table th, .table td {
            font-size: 14px; /* Ukuran font pada header tabel dan sel tabel diubah menjadi 14px */
        }

        /* Mengatur ukuran font untuk link dalam breadcrumb */
        .breadcrumb-item a {
            font-size: 14px; /* Ukuran font untuk teks dalam breadcrumb diubah menjadi 14px */
        }

    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Barang masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Barang Masuk</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Barang Masuk</h4>
                                <div class="card-header-action d-flex justify-content-between align-items-center">
                                <a href="{{ route ('barang_masuk.import')}}" class="btn btn-primary">IMPORT EXCEL</a>
                                <a href="{{ route('barang_masuk.create') }}" class="btn btn-primary">Tambah Barang Masuk</a>                                    
                                    <form action="{{ route('barang_masuk.search') }}" method="GET" class="d-flex">
                                        <input type="text" class="form-control me-2" name="query" placeholder="Cari Barang" required style="width: 100px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> <!-- Ikon pencarian -->
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Form Pilih Bulan untuk menampilkan Barang Keluar per bulan dan tahun -->
                                <div class="card-body">
                                    <form action="{{ route('barang_masuk.index') }}" method="GET" class="mb-4">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="bulan">Pilih Tahun dan Bulan:</label>
                                                <input type="text" id="datepicker" class="form-control" name="bulan" value="{{ request('bulan') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary mt-4">Tampilkan Barang Masuk</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>UOM</th>
                                                <th>Kuantitas</th>
                                                <th>Tanggal</th>
                                                <th>Nama Penerima</th>
                                                <th>Departemen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($barangMasuk as $barang)
                                                <tr>
                                                    <td>{{ $loop->iteration + ($barangMasuk->currentPage() - 1) * $barangMasuk->perPage() }}</td>
                                                    <td>{{ $barang->kode_barang }}</td>
                                                    <td>{{ $barang->nama_barang }}</td>
                                                    <td>{{ $barang->uom }}</td>
                                                    <td>{{ $barang->kuantitas }}</td>
                                                    <td>{{ $barang->tanggal }}</td>
                                                    <td>{{ $barang->nama_penerima }}</td>
                                                    <td>{{ $barang->departemen }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                        <!-- Tombol untuk download Excel -->
                                    <div class="float-right mb-3">
                                        <form action="{{ route('barang_masuk.export') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                            <button type="submit" class="btn btn-primary">Download Excel</button>
                                        </form>
                                    </div>
                                    <!-- Menampilkan pagination -->
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            Menampilkan {{ $barangMasuk->firstItem() }} sampai {{ $barangMasuk->lastItem() }} dari {{ $barangMasuk->total() }} data
                                        </div>
                                        <div>
                                            {{ $barangMasuk->appends(['bulan' => request('bulan')])->links() }} <!-- Pagination with bulan parameter -->
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

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

