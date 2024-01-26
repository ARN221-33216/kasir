<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Transaksi',
            'data_transaksi' => Transaksi::orderBy('id', 'desc')->get()
        ];

        return view('kasir.transaksi.list', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'title' => 'Create Data Transaksi'
        ];

        return view('kasir.transaksi.add', $data);
    }

    public function detail(Request $request, $no_transaksi)
    {
        $data = [
            'title' => 'Detail Data Transaksi',
            'data_transaksi' => Transaksi::where('no_transaksi', $no_transaksi)->first(),
            'data_detail' => DetailTransaksi::join('tbl_barang', 'tbl_barang.id', '=', 'tbl_detail_transaksi.id_barang')
                ->select('tbl_barang.*', 'tbl_detail_transaksi.*')
                ->where('no_transaksi', $no_transaksi)
                ->get()
        ];
 
    
        return view('kasir.transaksi.detail', $data);
    }

    public function cetakfaktur(Request $request, $no_transaksi)
    {
        $data = [
            'data_transaksi' => Transaksi::where('no_transaksi', $no_transaksi)->first(),
            'data_detail' => DetailTransaksi::join('tbl_barang', 'tbl_barang.id', '=', 'tbl_detail_transaksi.id_barang')
                ->select('tbl_barang.*', 'tbl_detail_transaksi.*')
                ->where('no_transaksi', $no_transaksi)
                ->get()
        ];
 

        return view('kasir.transaksi.cetakfaktur', $data);
    }
}
