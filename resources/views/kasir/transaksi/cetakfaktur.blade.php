<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Faktur Pembayaran</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/asset/images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="/asset/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/asset/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">

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

    <div class="col-4" style="margin:auto">
        <div class="invoice-title">
            <h2>Kang IT</h2>
            <h3>Jl. Tangerang</h3>
            <p>No: {{$data_transaksi->no_transaksi}}, {{ date('d/M/Y', strtotime($data_transaksi->tgl_transaksi))}} (customer), {{ date('H:i:s', strtotime($data_transaksi->created_at))}}
        </div>
        <div class="table-responsive">
            <table class=" ">
                <tr>

                    <th width="10%">Barang</th>
                    <th width="10%">Harga</th>
                    <th width="10%">Qty</th>
                    <th width="10%" style="text-align:right">Total</th>
                </tr>
                <tr>
                    <td colspan="4">
                        <hr>
                    </td>
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
                    <td colspan="4">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Total:</td>
                    <td style="text-align:right">{{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Diskon:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->diskon/100 * $total) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Total Bayar:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->total_bayar) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Uang Pembeli:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->uang_pembeli) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right">Kembalian:</td>
                    <td style="text-align:right">{{ number_format($data_transaksi->kembalian) }}</td>
                </tr>
            </table>
        </div>
    </div>




</body>
</html>
