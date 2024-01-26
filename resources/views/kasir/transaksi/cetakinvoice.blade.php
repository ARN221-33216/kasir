<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak Invoice</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/asset/images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="/asset/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/asset/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">

    <link href="/asset/css/style.css" rel="stylesheet">
    <style>
        .txt-center {
            text-align: center;
        }

        .box {
            width: 200px;
            height: 120px;
            border: 1px solid #000;
            margin-top: 20px;
        }

        @page {
            size: auto;
            margin: 0mm;
        }
 
    </style>
</head>

<body onload="window.print();" style="background-color: #FFFFFF !important; width:auto;">

    <div class="col-6" style="margin:auto">
        <div class="row">
            <div class="col-8">
                <strong>Kang IT</strong>
                <br>
                Tangerang Tangerang Tangerang Tangerang
                <br>
                Telp: 08125xxx xxx
            </div>
            <div class="col-4">
                <strong>INVOICE PENJUALAN</strong>
                <br>
                No. Trans: {{$data_transaksi->no_transaksi}}
                <br>
                Tanggal: {{ date('d/M/Y', strtotime($data_transaksi->tgl_transaksi))}}

            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table-bordered" style="line-height:2.1">
                <tr>

                    <th width="10%">Barang</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Qty</th>
                    <th width="10%" style="text-align:right">Subtotal</th>
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

                    <td>{{ $row->nama_barang }}</td>
                    <td>{{ number_format($row->harga) }}</td>
                    <td>{{ $row->qty }}</td>
                    <td style="text-align:right">{{ number_format($subtotal) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align:right">Total:</td>
                    <td style="text-align:right">{{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Diskon:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->diskon/100 * $total) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Total Yang Harus Dibayar:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->total_bayar) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Cash:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->uang_pembeli) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Kembalian:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->kembalian) }}</td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-4 txt-center">
                Diterima Oleh,
                <br><br><br><br><br>
                (..........)
            </div>
            <div class="col-4 txt-center box">

            </div>
            <div class="col-4 txt-center">
                TTD,
                <br><br><br><br><br>
                (..........)
            </div>
        </div>
    </div>
</body>
</html>
