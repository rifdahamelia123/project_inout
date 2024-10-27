@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        .container {
            margin-bottom: 10px; /* Atur jarak margin bawah agar lebih kecil */
        }

        .table-responsive {
            margin-top: 0px; /* Atur jarak margin atas agar lebih kecil */
        }

        .sidebar-brand {
            text-align: center;
        }

        .sidebar-brand strong {
            display: block;
            margin: 0;
        }

        .subtext {
            font-size: 11px; /* Ukuran lebih kecil */
            display: block;
            margin: 0; /* Hilangkan jarak antar baris */
            line-height: 0; /* Atur tinggi baris untuk rapat */
            white-space: nowrap; /* Mencegah pemisahan baris */
        }

        .card-icon {
            font-size: 32px;
            padding: 20px;
            color: #fff;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 70px;
            width: 70px;
        }

        .table-dashboard {
            width: 100%;
            text-align: center;
            border-spacing: 30px;
        }

        .table-dashboard td {
            vertical-align: top;
            padding: 30px;
        }

        .card {
            margin: 0 auto; 
        }
    
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <table class="table-dashboard">
                </table>
            </div>
             <!-- Menampilkan pesan sukses jika ada -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

            <!-- Menambahkan tabel Daftar Barang -->
            <div class="section-body">
                <div class="card">
                    <div class="card-body"><h5>Daftar Barang</h5>
                    <form action="{{ route('dashboard-simpadu.search') }}" method="GET" class="d-flex">
                        <input type="text" class="form-control me-2" name="query" placeholder="Cari Barang" required style="width:">
                            <button type="submit" class="btn btn-primary ">
                            <i class="fas fa-search"></i> <!-- Ikon pencarian -->
                            </button>
                       </form>
                      <div>
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>UOM</th>
                                    <th>MIN</th>
                                    <th>MAX</th>
                                    <th>IN</th>
                                    <th>OUT</th>
                                    <th>STOK</TH>
                                    <th>REMARK</th>
                                    <th>ORDER QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($dashboardSimpadu as $item)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->uom }}</td>
                                <td>{{ $item->min }}</td>
                                <td>{{ $item->max }}</td>
                                <td>{{ $item->in }}</td>
                                <td>{{ $item->out }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>{{ $item->order_qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                        </table>
                        <div class="card-header-action d-flex justify-content-between align-items-center">
                        <a href="{{ route('dashboard-simpadu.import') }}" class="btn btn-primary">IMPORT EXCEL</a>
                        <a href="{{ route('dashboard-simpadu.export')}}" class="btn btn-primary">EXPORT EXCEL</a> 
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>    
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>



    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush


























