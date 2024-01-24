@extends('layout.layout')
@section('content')
<div class="content-body">

    @include('layout.partials.navbar')
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="/transaksi/store" method="POST">
                        @csrf
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
                                        <th  style="text-align:right">Subtotal</th>
                                    </tr>
                                    @php
                                    $no = 1;
                                    $total = 0;
                                    @endphp
                                    @foreach($data_detail as $row)
                                    
                                    @php
                                        $subtotal = $row->harga *  $row->qty;
                                        $total += $subtotal;
                                    @endphp
                                    
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $row->nama_barang }}</td>
                                        <td>Rp. {{ number_format($row->harga) }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td  style="text-align:right">Rp. {{ number_format($subtotal) }}</td>
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
                            
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>


<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form method="POST" action="/transaksi/cart">
                @csrf
                <div class="modal-body">


                    <div class="form-group">
                        <label>Jenis Barang</label>
                        <select name="id_barang" class="form-control" required>
                            <option value="" hidden>--Pilih Nama Barang--</option>

                        </select>
                    </div>
                    <div id="tampil_barang"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-undo"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
