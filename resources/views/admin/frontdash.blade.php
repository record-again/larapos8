@extends('admin.dashboard')

@section('title', 'Dashboard')

@section('content')
    <h1>Kasir</h1>
    <div class="box">
        Kode Produk :<input type="text" id="src_kode" placeholder="Cari Kode..."> | 
        Nama Produk :<input type="text" id="src_kasir" placeholder="Cari Produk...">
        {{ csrf_field() }}
        <ul id="suggest"></ul><hr>
        <table id="keranjang">
            <tr>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>X</td>
                <td>Qty</td>
                <td>Jumlah</td>
                <td>#</td>
            </tr>
        </table>
        <br><br>
        <b>Total: <span id="total_bayar"></span></b>
    </div>
@endsection