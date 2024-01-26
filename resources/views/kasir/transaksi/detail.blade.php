@extends('layout.layout')
@section('content')
<div class="content-body">

    @include('layout.partials.navbar')
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">{{$title}}</h4>
                            <button class="btn btn-sm btn-primary" type="button" onclick="window.history.back();"><i class="fa fa-undo"></i> Kembali</button>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-md-6">
                                <table class="table header-border">
                                    <tr>
                                        <td width="30%"><strong>No Transaksi</strong></td>
                                        <td>: {{ $data_transaksi->no_transaksi }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table header-border">
                                    <tr>
                                        <td align="right"><strong>Tgl Transaksi</strong></td>
                                        <td width="30%">: {{ date('d/M/Y', strtotime($data_transaksi->tgl_transaksi)); }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th style="text-align:right">Subtotal</th>
                                </tr>
                                @php
                                $no = 1;
                                $total = 0;
                                @endphp
                                @foreach($data_detail as $row)

                                @php
                                $subtotal = $row->harga * $row->qty;
                                $total += $subtotal;
                                @endphp

                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->nama_barang }}</td>
                                    <td>Rp. {{ number_format($row->harga) }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td style="text-align:right">Rp. {{ number_format($subtotal) }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4">Total</th>
                                    <th style="text-align:right">Rp. {{ number_format($total) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Diskon</th>
                                    <th style="text-align:right">Rp. {{ number_format($data_transaksi->diskon/100 * $total) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Total Bayar</th>
                                    <th style="text-align:right">Rp. {{ number_format($data_transaksi->total_bayar) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Uang Pembeli</th>
                                    <th style="text-align:right">Rp. {{ number_format($data_transaksi->uang_pembeli) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Kembalian</th>
                                    <th style="text-align:right">Rp. {{ number_format($data_transaksi->kembalian) }}</th>
                                </tr>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>

    @endsection
