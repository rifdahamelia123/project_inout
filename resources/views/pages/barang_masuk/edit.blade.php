@extends('layouts.app')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
            <h1>Tambah Stok Barang Masuk</h1>
            <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('barang_masuk.index') }}">Barang Masuk</a></div>
                    <div class="breadcrumb-item">Edit</div>
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
                            <h4>Stok Barang Masuk</h4>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('barang_masuk.tambah', $item_masuk->kode_barang) }}" method="POST">
                                    @csrf
                                    @method('GET')

                                    <div class="form-group">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $item_masuk->kode_barang) }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $item_masuk->nama_barang) }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="uom">UOM</label>
                                        <input type="text" class="form-control" id="uom" name="uom" value="{{ old('uom', $item_masuk->uom) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kuantitas">Stok</label>
                                        <input type="text" class="form-control" id="stok" name="stok" value="{{ old('stok', $item_masuk->stok) }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="kuantitas">Jumlah Stok Masuk</label>
                                        <input type="number" class="form-control" id="masuk" name="masuk" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_penerima">Nama Penerima</label>
                                        <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', $item_masuk->nama_penerima) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="departemen">Departemen</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen" value="{{ old('departemen', $item_masuk->departemen) }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-info">Submit</button>
                                    <a href="{{ route('barang_masuk.index') }}" class="btn btn-secondary">Kembali</a>
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
