@extends('layouts.app')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Barang Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('barang_masuk.index') }}">Barang Masuk</a></div>
                    <div class="breadcrumb-item">Create</div>
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
                                <h4>Create Barang Masuk</h4>
                            </div>
                            <div class="card-body">
                                <!-- Ubah ke route barang_masuk.store -->
                                <form method="POST" action="{{ route('barang_masuk.store') }}">
                                    @csrf

                                    <!-- Ambil data nama barang dari database -->
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <select class="form-control" name="kode_barang" required>
                                            <option disabled selected value="">Pilih Barang</option>
                                            @foreach($barang as $item)
                                                <option value="{{ $item->kode_barang }}">{{ $item->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_waktu">Tanggal Waktu</label>
                                        <input type="datetime-local" name="tanggal_waktu" id="tanggal_waktu" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kuantitas">Kuantitas</label>
                                        <input type="number" name="kuantitas" id="kuantitas" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <a href="{{ route('barang_masuk.index') }}" class="btn btn-info">Cancel</a>
                                    </div>
                                </form>
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
