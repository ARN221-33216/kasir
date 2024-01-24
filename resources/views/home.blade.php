@extends('layout.layout')
@section('content')
<div class="content-body">

    @include('layout.partials.navbar')
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card card-widget">
                    <div class="card-body gradient-3">
                        <div class="media">
                            <span class="card-widget__icon"><i class="fa fa-briefcase"></i></span>
                            <div class="media-body">
                                <h2 class="card-widget__title">{{ $data_barang_cnt }}</h2>
                                <h5 class="card-widget__subtitle">Data Barang</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card card-widget">
                    <div class="card-body gradient-4">
                        <div class="media">
                            <span class="card-widget__icon"><i class="fa fa-desktop"></i></span>
                            <div class="media-body">
                                <h2 class="card-widget__title">{{ $data_transaksi_cnt }}</h2>
                                <h5 class="card-widget__subtitle">Data Transaksi</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card card-widget">
                    <div class="card-body gradient-9">
                        <div class="media">
                            <span class="card-widget__icon"><i class="fa fa-money"></i></span>
                            <div class="media-body">
                                <h2 class="card-widget__title">Rp. {{number_format($data_pendapatan_hari_ini)}}</h2>
                                <h5 class="card-widget__subtitle">Pendapatan Hari Ini</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if (auth()->user()->isAdmin())
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Stok Barang Menipis</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jenis</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($data_barang as $row)


                                    <tr>
                                        <td>{{ $no++}}</td>
                                        <td>{{ $row->nama_barang }}</td>
                                        <td>{{ $row->nama_jenis }}</td>
                                        <td>{{ $row->stok }} Pcs</td>
                                        <td>Rp. {{ number_format($row->harga) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Single Bar Chart -->
            <div class="col-8">
                <div class="card">
                    <div class="card-body">

                        <canvas id="singelBarChart" width="500" height="250"></canvas>
                    </div>
                </div>
            </div>
            @endif


            <div class="col-4">
                <div class="card card-widget">
                    <div class="card-body gradient-1">
                        <div class="media">
                            <span class="card-widget__icon"><i class="fa fa-money"></i></span>
                            <div class="media-body">
                                <h2 class="card-widget__title">Rp. {{number_format($data_seluruh_pendapatan) }}</h2>
                                <h5 class="card-widget__subtitle">Seluruh Pendapatan</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->

</div>
@endsection

@push('script')
<script src="/asset/plugins/chart.js/Chart.bundle.min.js"></script>
<script>
    var ctx = document.getElementById("singelBarChart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'bar'
        , data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nop", "Des"]
            , datasets: [{
                label: "Data Transaksi Perbulan dan Tahun Ini"
                , data: [{{ $stats }}]
                , borderColor: "rgba(117, 113, 249, 0.9)"
                , borderWidth: "0"
                , backgroundColor: "blue"
            }]
        }
        , options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

</script>
@endpush
