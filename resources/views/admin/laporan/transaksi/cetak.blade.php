<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak Laporan</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/asset/images/favicon.png">
 
    <link href="/asset/css/style.css" rel="stylesheet">
    <style>
        .invoice-title {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            line-height: 35px;
        }

    </style>

</head>

<body onload="window.print();" style="background-color: #FFFFFF !important;">

    <div class="col-11" style="margin:auto; border:1px solid #000">

        <div class="invoice-title" style="margin-right:50px;">
            <img src="https://png.pngtree.com/png-vector/20191206/ourmid/pngtree-cake-piece-vector-or-color-illustration-png-image_2032207.jpg" style="width: 3.5rem; float:left; margin-left:20px">
            <h2>Kang IT</h2>
            <h3>Jl. Tangerang</h3>
            <p>08128388xxxx </p>

        </div>
        <div class="table-responsive">
          <hr>
            <h4 class="invoice-title">LAPORAN TRANSAKSI</h4>
            <br>
            <table class="table table-bordered">
                <tr>
                    <th width="10%">No</th>
                    <th width="10%">No. Transaksi</th>
                    <th width="10%">Tgl. Transaksi</th>
                    <th width="10%" style="text-align:right">Total Bayar</th>
                </tr>
                @php
                $no = 1;
                $total = 0;
                @endphp
                @foreach($data_transaksi as $row)

                @php
                $total += $row->total_bayar;
                @endphp

                <tr>
                    <td>{{ $no++ }}.</td>
                    <td>{{ $row->no_transaksi }}</td>
                    <td>{{ date('d/M/Y', strtotime($row->tgl_transaksi)); }}</td>
                    <td style="text-align:right">Rp. {{ number_format($row->total_bayar) }}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="3">Seluruh Total:</th>
                    <th style="text-align:right">Rp.{{ number_format($total) }}</th>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
