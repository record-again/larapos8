<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $bulan = DB::table('transaksi')
                    ->selectRaw('DATE_FORMAT(created_at, "%m") as bulan')
                    ->distinct()
                    ->get();

        $tahun = DB::table('transaksi')
                    ->selectRaw('DATE_FORMAT(created_at, "%Y") as tahun')
                    ->distinct()
                    ->get();
        
        $kategori = Kategori::all();

        return view('admin.laporan', ['bulan' => $bulan, 'tahun' => $tahun, 'kategori' => $kategori]);
    }

    public function cashpdf(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $year = $request->year;
    
        $data = DB::table('transaksi')
                    // ->selectRaw('DATE_FORMAT(created_at, "%Y") as tahun')
                    ->whereMonth('created_at', '>=', $from)
                    ->whereMonth('created_at', '<=', $to)
                    ->whereYear('created_at', $year)
                    ->get();
        
        $bulan = function($int) {
            return date("F", mktime(0, 0, 0, $int, 1));
        };

        $pdf = PDF::loadView('laporan.transaksi', ['transaksi' => $data, 'from' => $bulan($from), 'to' => $bulan($to), 'year' => $year]);
        return $pdf->stream('Transaksi '.$bulan($from).' - '.$bulan($to).' #'.$year.'.pdf');
    }

    public function barangpdf(Request $request)
    {
        $kategori = $request->cat;
        $from = $request->fnumber;
        $to = $request->tnumber;
        if($kategori == 'all') {
            $data = DB::table('barang')
                            ->whereBetween('stok_barang', [$from, $to])
                            ->get();
        }
        elseif($kategori != null) {
            $data = DB::table('kategori')
                            ->join('barang', 'kategori.id_kategori', '=', 'barang.id_kategori')
                            ->where('kategori.id_kategori', $kategori)
                            ->whereBetween('stok_barang', [$from, $to])
                            ->get();
        }
        elseif($kategori != 'all') {
            $data = DB::table('kategori')
                            ->join('barang', 'kategori.id_kategori', '=', 'barang.id_kategori')
                            ->where('kategori.id_kategori', $kategori)
                            ->get();
        }


        $namecat = ($kategori != 'all') ? Kategori::find($kategori)->nama_kategori : 'Semua';

        $pdf = PDF::loadView('laporan.barang', ['barang' => $data, 'kategori' => $namecat]);
        return $pdf->stream('Barang '.$namecat.'.pdf');
    }

    public function temp()
    {
        $data = Transaksi::orderBy('created_at', 'desc')->get();
        // dd($data[0]->json_barang);
        return view('laporan.transaksi', ['transaksi' => $data]);
    }
}
