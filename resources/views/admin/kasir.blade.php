@extends('admin.dashboard')

@section('title', 'Kasir')

@section('content')
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">SCAN KODE</span>
                        <input class="form-control" type="search" id="src_kode" placeholder="Kode Produk...">
                    </div>
                </div>
                <div col-md-6>
                    <div class="input-group">
                        <span class="input-group-addon">CARI PRODUK</span>
                        <input class="form-control" type="search" id="src_kasir" placeholder="Nama Produk...">
                    </div>
                </div>
                <ul class="sugstyle" id="suggest"></ul>
                {{ csrf_field() }}
            </div>
        </div>
        <span id="alert-box"></span>
        <div class="panel panel-default">
            <div class="panel-heading">Keranjang</div>
                <table class="table" id="keranjang">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>X</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                            <th>#</th>
                        </tr>
                </table>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-default">
            <ul class="list-group">
                <li class="list-group-item"><h3 style="color: tomato; font-weight: bold;">Total: <span id="total-bayar"></span></h3></li>
                <li class="list-group-item form-group">
                    <label for="txtbayar">Bayar</label>
                    <input id="txtbayar" class="form-control" type="text" value="0" style="font-weight: bold;"><br>
                    <button id="btn-bayar" type="button" class="btn btn-success" style="float: right;">BAYAR</button><br><br>
                </li>
                <li class="list-group-item form-group">
                    <b>Uang Kembali</b><br>
                    <h4><span data-value="0" id="uang-kembali">0</span></h4>
                </li>
                <li class="list-group-item">
                    <input id="txt-namatun" class="form-control" type="text" placeholder="Nama" style="display: none;"><br><br>
                    <button id="btn-tunda" type="button" class="btn btn-warning">TUNDA</button>
                    <button id="btn-selesai" type="button" class="btn btn-primary" style="float: right; display: none;">SELESAI</button>
                </li>
            </ul>
        </div>
    </div>
@endsection