<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');

        $months = array_fill_keys(range(1, 12), 0);
        $trx = DB::table('tbl_transaksi')
            ->select(DB::raw('MONTH(tgl_transaksi) as month'), DB::raw('COUNT(*) as transaction_count'))
            ->whereRaw('YEAR(tgl_transaksi) = ' . date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->transaction_count];
            });

        foreach ($trx as $key => $val) {
            $months[$key] = $val;
        }

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
                ->get(),
            'stats' => implode(',', $months)
        ];


        return view('home', $data);
    }
}
