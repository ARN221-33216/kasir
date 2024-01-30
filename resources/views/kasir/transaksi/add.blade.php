@extends('layout.layout')
@push('css')
<style>
    .txt-right {
        float: right;
    }

    .five-percent-width {
        width: 5%;
    }

</style>
@endpush
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
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">{{$title}}</h4>

                            </div>
                            <hr>
                            <button class="btn btn-sm btn-primary" type="button" data-target="#modalCreate" data-toggle="modal"><i class="fa fa-plus"></i> Tambah Data</button>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($cart->items as $id_barang => $barang)
                                    <tr>
                                        <td class="five-percent-width">{{ $no++ }}.</td>
                                        <td>{{ $barang['nama_barang'] }}</td>
                                        <td>Rp. <span class="txt-right">{{ number_format($barang['harga']) }}</span></td>
                                        <td class="five-percent-width">{{ $barang['qty'] }}</td>
                                        <td>Rp. <span class="txt-right">{{ number_format($barang['subtotal']) }}</span></td>
                                        <td class="five-percent-width"><a href="/transaksi/remove/{{$id_barang}}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>Hapus</a></td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="4">Total </td>
                                        <td>Rp. <span class="txt-right">{{ number_format($cart->total)}}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Diskon</td>
                                        <td>Rp. <span class="txt-right">{{ number_format($cart->total_diskon)}}</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Total Bayar</td>
                                        <td>Rp. <span class="txt-right" id="total_bayar">{{ number_format($cart->total_bayar)}}</span></td>
                                        <td></td>
                                    </tr>
                                </table>
                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label> No Transaksi</label>
                                            <input type="text" class="form-control" name="no_transaksi" value="{{$no_transaksi}}" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label> Tgl Transaksi</label>
                                            <input type="text" class="form-control" value="{{ date('d/M/Y')}}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Uang Pembeli</label>
                                            <input type="text" class="form-control" name="uang_pembeli" id="uang_pembeli" onkeyup="hitungKembalian()" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kembalian</label>
                                            <input type="text" class="form-control" value="" id="kembalian" name="kembalian" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>Save Changes</button>
                                <a href="/transaksi" class="btn btn-danger"><i class="fa fa-undo"></i>Cancel</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>


<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
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
                        <select name="id_barang" id="id_barang" class="form-control" required>
                            <option value="" hidden>--Pilih Nama Barang--</option>
                            @foreach($data_barang as $val)

                            <option value="{{$val->id}}">{{$val->nama_barang}}</option>
                            @endforeach

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

@push('script')
<script>
    $(document).ready(function() {
        $('form').submit(function() {
            $('input[type="text"]').each(function() {
                $(this).val($(this).val().replace(/,/g, '')); // Remove commas
            });
        });

        $("#id_barang").change(function() {
            var id_barang = $("#id_barang").val();
            $.ajax({
                url: "/transaksi/detailbarang/" + id_barang
                , type: "GET"
                , dataType: "html"
                , success: function(data) {
                    $('#tampil_barang').html(data);
                }
                , error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);

                }
            });
        });
    });


    function hitungKembalian() {
        var total_bayar = $("#total_bayar").text().replace(/,/g, "");
        var uang_pembeli = $("#uang_pembeli").val();

        var kembalian = parseInt(uang_pembeli) - parseInt(total_bayar);

        if (kembalian > 0) {
            $("#kembalian").val(kembalian.toLocaleString());
        } else {
            $("#kembalian").val(0);
        }
    }

</script>

@endpush
