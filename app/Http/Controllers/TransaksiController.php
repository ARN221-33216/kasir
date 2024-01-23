<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Transaksi',
            'data_transaksi' => Transaksi::all()
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
}
