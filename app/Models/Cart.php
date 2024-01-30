<?php

namespace App\Models;
use Session;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $items = [];
    public $diskon = 0;
    public $total = 0;
    public $total_bayar = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->total = $oldCart->total;
            $this->diskon = $oldCart->diskon;
            $this->total_diskon = $oldCart->total_diskon;
            $this->total_bayar = $oldCart->total_bayar;
        }
    }

    public function add($barang, $qty) {
        
        /*if (array_key_exists($barang->id, $this->items)) {
            $this->items[$barang->id]['qty'] += $qty;
            $this->items[$barang->id]['subtotal'] = $barang->harga * $this->items[$barang->id]['qty'];
        }else{*/
            $this->items[$barang->id]['qty'] = $qty;
            $this->items[$barang->id]['nama_barang'] = $barang->nama_barang;
            $this->items[$barang->id]['harga'] = $barang->harga;
            $this->items[$barang->id]['subtotal'] = $barang->harga * $this->items[$barang->id]['qty'];
        //}

        $this->calculate();
    }

    public function remove($id) {
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);
        }

        $this->calculate();
    }

    private function calculate(){
        $diskon = Diskon::first();
        
        $total = 0;
        $total_diskon = 0;
        $total_bayar = 0;
        foreach ($this->items as $key => $value) {
            $subtotal = $value['harga'] * $value['qty'] ;
            $total += $subtotal;
        }

        $total_bayar = $total;
        if($total && ($total >= $diskon->total_belanja)){
            $total_diskon = $diskon->diskon / 100 * $total;
            $total_bayar = $total - $total_diskon;
        }

        $this->total = $total;
        $this->diskon = $diskon->diskon;
        $this->total_diskon = $total_diskon;

        $this->total_bayar = $total_bayar;
    }
}
