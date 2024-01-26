@extends('layout.layout')
@section('content')
<div class="content-body">
 
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{$title}}</h4>
                            <a href="/transaksi/create" class="btn btn-primary btn-round ml-auto">
                                <i class="fa fa-plus">
                                </i>Tambah Data
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Total Bayar</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($data_transaksi as $row)

                                    <tr>
                                        <td>{{ $no++}}</td>
                                        <td>{{ $row->no_transaksi }}</td>
                                        <td>{{ date('d/M/Y', strtotime($row->tgl_transaksi)) }}</td>
                                        <td>Rp. {{ number_format($row->total_bayar) }}</td>
                                        <td>
                                            <a href="/transaksi/detail/{{$row->no_transaksi}}" class="btn btn-xs btn-success"><i class="fa fa-list"></i>Detail</a>
                                            <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-print"></i>Cetak</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="/transaksi/cetakfaktur/{{$row->no_transaksi}}">Cetak Faktur</a>
                                                <a class="dropdown-item" href="/transaksi/cetakinvoice/{{$row->no_transaksi}}">Cetak Invoice</a>
                                            </div>

                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>

@endsection
