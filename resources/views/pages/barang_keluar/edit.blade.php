@extends('layouts.app')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Barang Keluar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('barang_keluar.index') }}">Barang Keluar</a></div>
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
                                <h4>Edit Barang Keluar</h4>
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

                                <form action="{{ route('barang_keluar.tambah', $item_keluar->kode_barang) }}" method="POST">
                                    @csrf
                                    @method('GET')

                                    <div class="form-group">
                                        <label for="kode_barang">Kode Barang</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $item_keluar->kode_barang) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $item_keluar->nama_barang) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="uom">UOM</label>
                                        <input type="text" class="form-control" id="uom" name="uom" value="{{ old('uom', $item_keluar->uom) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kuantitas">Kuantitas</label>
                                        <input type="text" class="form-control" id="kuantitas" name="kuantitas" value="{{ old('kuantitas', $item_keluar->kuantitas) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_penerima">Nama Penerima</label>
                                        <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima',$item_keluar->nama_penerima) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="departemen">Departemen</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen" value="{{ old('departemen', $item_keluar->departemen) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', $item_keluar->jabatan) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keperluan">Keperluan</label>
                                        <input type="text" class="form-control" id="keperluan" name="keperluan" value="{{ old('keperluan', $item_keluar->keperluan) }}" required>
                                    </div>


                                    <button type="submit" class="btn btn-info">Submit</button>
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
