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
                            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCetak">
                                <i class="fa fa-print">
                                </i>Cetak Data
                            </button>
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


<div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form method="POST" action="/laporan/cetak">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        Tgl Mulai
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="dd/mm/yyyy" name="date1" required> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                        </div>
                        <br>
                        Tgl Selesai
                        <div class="input-group">
                            <input type="text" class="form-control mydatepicker" placeholder="dd/mm/yyyy" name="date2" required> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-undo"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-print"></i>Cetak Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // Date Picker
    jQuery('.mydatepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
    });
</script>
@endpush