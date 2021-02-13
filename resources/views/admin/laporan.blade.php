@extends('admin.dashboard')

@section('title', 'Laporan')
    
@section('content')
    <div class="row">
        <h4>Laporan Transaksi</h4>
        <div class="form-group">
            <form action="/transpdf" method="get" target="_blank">
                <div class="col-md-3">
                    <label for="">Dari Bulan</label>
                    <select class="form-control" name="from" id="">
                        @foreach ($bulan as $month)
                            <option value="{{ $month->bulan }}">{{ bulan($month->bulan) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Sampai Bulan</label>
                    <select class="form-control" name="to" id="">
                        @foreach ($bulan as $month)
                            <option value="{{ $month->bulan }}">{{ bulan($month->bulan) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Tahun</label>
                    <select class="form-control" name="year" id="">
                        @foreach ($tahun as $year)
                            <option value="{{ $year->tahun }}">{{ $year->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input class="btn btn-primary" type="submit" value="PRINT" style="margin-top: 25px;">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <h4>Laporan Barang</h4>
        <div class="form-group">
            <form action="/barpdf" method="get" target="_blank">
                <div class="col-md-2">
                    <label for="">Kategori</label>
                        <select class="form-control" name="cat" id="">
                            <option value="all">Semua Kategori</option>
                            @foreach ($kategori as $cat)
                                <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-1">
                    <label for="">Dari Stok</label>
                    <input class="form-control" type="number" name="fnumber" value="1">
                </div>
                <div class="col-md-2">
                    <label for="">Sampai Stok</label>
                    <input class="form-control" type="number" name="tnumber" value="10">
                </div>
                <div class="col-md-2">
                    <input class="btn btn-primary" type="submit" value="PRINT" style="margin-top: 25px;">
                </div>
            </form>
        </div>
    </div>
@endsection