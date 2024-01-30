<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Cart;
use Session;

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

    public function create()
    {
        $cart = new Cart(Session::get('cart'));
        $id = Transaksi::max('id');
        $no_transaksi = "NT-" . str_pad(++$id, 3, '0', STR_PAD_LEFT);

        $data = [
            'title' => 'Create Data Transaksi',
            'data_barang' => Barang::all(),
            'cart' => $cart,
            'no_transaksi' => $no_transaksi
        ];


        return view('kasir.transaksi.add', $data);
    }

    public function detail($no_transaksi)
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

    public function cetakfaktur($no_transaksi)
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

    public function cetakinvoice($no_transaksi)
    {
        $data = [
            'data_transaksi' => Transaksi::where('no_transaksi', $no_transaksi)->first(),
            'data_detail' => DetailTransaksi::join('tbl_barang', 'tbl_barang.id', '=', 'tbl_detail_transaksi.id_barang')
                ->select('tbl_barang.*', 'tbl_detail_transaksi.*')
                ->where('no_transaksi', $no_transaksi)
                ->get()
        ];


        return view('kasir.transaksi.cetakinvoice', $data);
    }

    public function detailbarang($id_barang)
    {
        $data = array(
            'detail_barang' => Barang::where('id', $id_barang)->get(),
        );

        return view('kasir/transaksi/detailbarang', $data);
    }

    public function cart(Request $request)
    {

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $barang = Barang::find($request->id_barang);

        if ($request->qty > $barang->stok) {
            return redirect('/transaksi/create')->with(
                'error',
                'QTY lebih dari stok',
            );
        }
        $cart->add($barang, $request->qty);


        Session::put('cart', $cart);

        return redirect('/transaksi/create')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function remove($id_barang)
    {

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $cart->remove($id_barang);

        Session::put('cart', $cart);

        return redirect('/transaksi/create')->with('success', 'Data Berhasil Dihapus');
    }

    public function store(Request $request)
    {
        try {
            $cart = new Cart(Session::get('cart'));

            $transaksi = Transaksi::create([
                'no_transaksi'  => $request->no_transaksi,
                'tgl_transaksi' => date('Y-m-d'),
                'diskon'        => $cart->diskon,
                'uang_pembeli'  => $request->uang_pembeli,
                'total_bayar'   => $cart->total_bayar,
                'kembalian'     => $request->kembalian,
            ]);

            $details = [];
            foreach ($cart->items as $id_barang => $item) {
                $details[] = [
                    'id_barang' => $id_barang,
                    'qty' => $item['qty'],
                ];

                $barang = Barang::find($id_barang);
                $barang->stok -= $item['qty'];
                $barang->save();
            }
            $transaksi->details()->createMany($details);

            return redirect('/transaksi')->with('success', 'Data Berhasil Disimpan');
        } catch (\Exception $e) {
            return redirect('/transaksi')->with('error', $e->getMessage());
        } finally {
            Session::forget('cart');
        }
    }

    public function laporan()
    {
        $data = [
            'title' => 'Data Laporan',
            'data_transaksi' => Transaksi::all()
        ];

        return view('admin.laporan.transaksi.list', $data);
    }

    public function laporancetak(Request $request)
    {

        $date1 = \DateTime::createFromFormat("d/m/Y", $request->date1);
        $newDate1 = $date1->format("Y-m-d");
        
        $date2 = \DateTime::createFromFormat("d/m/Y", $request->date2);
        $newDate2 = $date2->format("Y-m-d");
 
        $data = [
            'title' => 'Cetak Laporan',
            'data_transaksi' => Transaksi::whereBetween('tgl_transaksi', [$newDate1, $newDate2])->get()
        ];
 
        return view('admin.laporan.transaksi.cetak', $data);
    }
}
