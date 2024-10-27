@extends('layouts.app')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Import Barang Masuk</h1>
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
                            <h4>Import Excel </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('barang_masuk.import.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file_excel">Pilih File Excel</label>
                                    <input type="file" name="file_excel" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Import</button>
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
