<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;

class BarangController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $search = $request->bsrc;
        $kategori = $request->cat;
        if($search != null) {
            $data = DB::table('barang')
                        ->join('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
                        ->where('nama_barang', 'like', '%'.$search.'%')->paginate(10);
        }
        elseif($kategori != null) {
            $data = DB::table('barang')
                        ->join('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
                        ->where('barang.id_kategori', $kategori)->paginate(10);
        }
        else {
            $data = DB::table('barang')
                        ->join('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
                        ->orderBy('barang.created_at', 'desc')->paginate(10);
        }

        $kategori = DB::table('barang')
                        ->join('kategori', 'barang.id_kategori', '=', 'kategori.id_kategori')
                        ->select('barang.id_kategori as id_kategori' ,'kategori.nama_kategori as nama_kategori')
                        ->distinct()->get();
    
        return view('admin/listbarang', ['barang' => $data, 'kategori' => $kategori]);
    }

    public function form()
    {
        $kategori = Kategori::all()->sortByDesc('created_at');
        return view('admin/formbarang', [ 'kategori' => $kategori ]);
    }

    public function insert(Request $request)
    {
        $messages = [
            'id_barang.required' => 'Kode Barang Harus Di Isi',
            'id_barang.uniqe' => 'Kode Barang Sudah Digunakan',
            'nama_barang.required' => 'Nama Barang Harus Di Isi',
            'nama_barang.uniqe' => 'Nama Barang Sudah Ada',
            'harga_barang.required' => 'Harga Barang Harus Di Isi',
            'stok_barang.required' => 'Stok Barang Harus Di Isi',
        ];

        $validated = $request->validate([
            'id_barang' => 'required|unique:barang|max:255',
            'nama_barang' => 'required|unique:barang|max:255',
            'harga_barang' => 'required|numeric',
            'stok_barang' => 'required|numeric',
        ], $messages);
        
        $barang = new Barang;
        $barang->id_barang = $request->id_barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->desc_barang = $request->deskripsi_barang;
        $barang->stok_barang = $request->stok_barang;
        $barang->terjual = 0;
        $barang->id_kategori = $request->id_kategori;
        $barang->save();

        return redirect('/barang')->with('pesaninput', $request->nama_barang.' Berhasil Di Tambah');
        
        // DB::table('barangs')->insert([
        //     'id_barang' => 4,
        //     'nama_barang' => 'Baju',
        //     'desc_barang' => 'Pakaian anak',
        //     'qty_barang' => '50'
        // ]);
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        $kategori = Kategori::all();
        return view('admin/formeditbarang', ['barang' => $barang, 'kategori' => $kategori]);

    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        $barang->id_barang = $request->id_barang;
        $barang->nama_barang = $request->nm_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->desc_barang = $request->deskripsi_barang;
        $barang->stok_barang = $request->stok_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->save();

        return redirect('/barang')->with('pesanupdate', $request->nm_barang.' Berhasil Di Update');

        // DB::table('barangs')->where('id_barang', 1)->update([
        //     'nama_barang' => 'Pepsodeng Hijau'
        // ]);
    }

    public function delete($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('/barang')->with('pesandelete', $barang->nama_barang.' Berhasil Di Hapus');
        // DB::table('barangs')->where('id_barang', 4)->delete();
    }

    public function validkode(Request $request)
    {
        $barang = Barang::find($request->kode);
        if($barang) {
            return 'false';
        }
        else {
            return 'true';
        }
    }

    public function kodeSrc(Request $request)
    {
        // $barang = Barang::find($request->srcdata);
        $barang = DB::table('barang')->where('id_barang', $request->srcdata)->paginate(10);
        return $barang;
        
    }

    public function search(Request $request)
    {
        $barang = DB::table('barang')->where('nama_barang', 'like', '%'.$request->srcdata.'%')->get();
        if($barang) {
            return $barang;
        }
        
        return true;
        // dd($barang);
    }

    public function month()
    {
        // $transaksi = DB::select("select sum(total_bayar) as pendapatan, DATE_FORMAT(created_at, '%Y-02-%d') as tanggal from transaksi group by DATE_FORMAT(created_at, '2021-02-%d') ORDER BY tanggal DESC");
        
        $transaksi = DB::select("SELECT EXTRACT(MONTH from created_at) as bulan, SUM(total_bayar) as pendapatan FROM transaksi GROUP BY bulan");

        return $transaksi;
    }

    public function sellprod()
    {
        $jual = Barang::select('nama_barang', 'terjual')
                        ->orderByDesc('terjual')->get();
        
        return $jual;
    }

    public function grafik()
    {
        return view('admin/grafik');
    }
}
