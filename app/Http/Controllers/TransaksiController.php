<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use PDF;

class TransaksiController extends Controller
{
    public function __construct()
    {
       //
    }
    public function buy()
    {
        return view('admin/kasir');
    }
    public function datalist(Request $request)
    {
        $search = $request->tsrc;
        $status = $request->status;
        $where = $request->where;
        if($search != null) {
            if($where == 'kode') {
                $data = Transaksi::where('id_transaksi', $search)->paginate(10);
            }
            else {
                $data = Transaksi::where('nama_pembeli', 'like', '%'.$search.'%')->paginate(10);
            }
        }
        elseif($status != null) {
            $data = Transaksi::orderBy('created_at', 'desc')->where('status', $status)->paginate(10);
        }
        else {
            $data = Transaksi::orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('admin.listtransaksi', [ 'transaksi' => $data, 'combo' => $where, 'oldsrc' => $search ]);
    }
    public function view($id)
    {
        $data = Transaksi::find($id);
        return view('admin.edittransaksi', [ 'transaksi' => $data ]);
    }

    public function store(Request $request)
    {
        $transaksi = new Transaksi;
        $transaksi->nama_pembeli = $request->nama;
        $transaksi->total_bayar = $request->totalbayar;
        $transaksi->uang_bayar = $request->uangbayar;
        $transaksi->uang_kembali = $request->uangkembali;
        $transaksi->json_barang = $request->barang;
        $transaksi->status = $request->status;
        $transaksi->save();

        $minbarang = Transaksi::find($transaksi->id_transaksi);
        $minbarang = $minbarang->json_barang;
        $minbarang = json_decode($minbarang);
        foreach($minbarang as $row) {
            $barang = Barang::find($row->idbarang);
            $barang->stok_barang = $barang->stok_barang - $row->qty;
            $barang->terjual = $barang->terjual + $row->qty;
            $barang->save();

        }

        return $transaksi->id_transaksi;
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if(!$transaksi)
            abort(404);
        $transaksi->status = $request->opt_status;
        $transaksi->save();

        return redirect('/transaksi/'.$id.'/edit');
        
    }

    public function delete($id)
    {
     $transaksi = Transaksi::find($id);
     if(!$transaksi)
            abort(404);
     $transaksi->delete();

     return redirect('/alltransaksi');
    }

    public function temp()
    {
        // $pdf = PDF::loadView('pdf');
        $pdf = PDF::loadHTML("<h1>halo pdf</h1>");

        return $pdf->stream();
        // return $pdf->download('invoice.pdf');

    }
}
