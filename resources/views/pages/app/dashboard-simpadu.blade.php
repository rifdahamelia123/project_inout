@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        .card-icon {
            font-size: 32px;
            padding: 20px;
            color: #fff;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            width: 80px;
        }
        .table-dashboard {
            width: 100%;
            text-align: center;
            border-spacing: 320px;
        }
        .table-dashboard td {
            vertical-align: top;
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
                    <tr>
                        <!-- Stok Terbanyak -->
                        <td>
                            <div class="card card-statistic-1 text-center">
                                <div class="card-icon bg-primary">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Stok Terbanyak</h4>
                                    </div>
                                    <div class="card-body">
                                    10
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Stok Terendah -->
                        <td>
                            <div class="card card-statistic-1 text-center">
                                <div class="card-icon bg-danger">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Stok Terendah</h4>
                                    </div>
                                    <div class="card-body">
                                    5
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Jumlah Item -->
                        <td>
                            <div class="card card-statistic-1 text-center">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Jumlah Item</h4>
                                    </div>
                                    <div class="card-body">
                                    2 
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
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
