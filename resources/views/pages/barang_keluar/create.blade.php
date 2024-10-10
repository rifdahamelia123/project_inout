@extends('layouts.app')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Barang Keluar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('barang_keluar.index') }}">Barang Keluar</a></div>
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
                                <h4>Create Barang Keluar</h4>
                            </div>
                            <div class="card-body">
                            <form method="POST" action="{{ route('barang_keluar.store') }}">
                                    @csrf

                                    <!-- Dropdown untuk memilih nama barang -->
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <select class="form-control" name="nama_barang" required>
                                            <option disabled selected value="">-- Pilih Barang --</option>
                                            @foreach($barangs as $barang) <!-- Asumsikan Anda memuat data barang dari controller -->
                                                <option value="{{ $barang->kode_barang }}">{{ $barang->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Input untuk tanggal dan waktu -->
                                    <div class="form-group">
                                        <label for="tanggal_waktu">Tanggal Waktu</label>
                                        <input type="datetime-local" name="tanggal_waktu" id="tanggal_waktu" class="form-control" required>
                                    </div>

                                    <!-- Input untuk kuantitas barang keluar -->
                                    <div class="form-group">
                                        <label for="keluar">Kuantitas Keluar</label>
                                        <input type="number" class="form-control" id="keluar" name="keluar" value="{{ old('keluar') }}" required>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <a href="{{ route('barang_keluar.index') }}" class="btn btn-info">Cancel</a>
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
