<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Barang;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');

        $transactions =

            $data = [
                'title' => 'Home Page',
                'data_barang_cnt' => Barang::count(),
                'data_transaksi_cnt' => Transaksi::count(),
                'data_pendapatan_hari_ini' =>  Transaksi::where('tgl_transaksi', $today)->sum('total_bayar'),
                'data_seluruh_pendapatan' => Transaksi::sum('total_bayar'),
                'data_barang' => Barang::join('tbl_jenis_barang', 'tbl_jenis_barang.id', '=', 'tbl_barang.id_jenis')
                    ->select('tbl_barang.*', 'tbl_jenis_barang.nama_jenis')
                    ->where('stok', '<', 10)
                    ->orderBy('stok', 'asc')
                    ->get()
            ];

        return view('home', $data);
    }
}
