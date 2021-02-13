@extends('admin.dashboard')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <ul class="list-group">
                <li class="list-group-item active"><b>Kode Transaksi #{{ $transaksi->id_transaksi }}</b></li>
                <li class="list-group-item">Nama Pembeli : {{ $transaksi->nama_pembeli }}</li>
                <li class="list-group-item">Total Belanja : @currency($transaksi->total_bayar)</li>
                <li class="list-group-item">Uang Bayar :  @currency($transaksi->uang_bayar)</li>
                <li class="list-group-item">Uang Kembali :  @currency($transaksi->uang_kembali)</li>
            </ul>
        </div>
        <div class="col-md-7">
            <div class="panel panel-primary">
                <div class="panel-heading"><b>Barang</b></div>
                <table class="table">
                    @php
                        $barang = json_decode($transaksi->json_barang);
                        foreach ($barang as $item):
                    @endphp    
                        <tr>
                            <td>{{ $item->nmbarang }}</td>
                            <td>Rp. @currency($item->harga)</td>
                            <td>x</td>
                            <td>{{ $item->qty }}</td>
                            <td>=</td>
                            <td>@currency($item->subtotal)</td>
                        </tr>
                    @php endforeach; @endphp
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="/updatetrans/{{ $transaksi->id_transaksi }}" method="post">
                <div class="form-group">
                    <label for="">Status</label>
                    <select class="form-control" name="opt_status" id="">
                        @if ( $transaksi->status == 'Lunas' )
                        <option value="Lunas" selected>Lunas</option>
                            <option value="Tunda">Tunda</option>
                        @else
                        <option value="Lunas">Lunas</option>
                        <option value="Tunda" selected>Tunda</option>
                        @endif
                    </select>
                </div>
                <input class="btn btn-warning" type="button" value="BACK" onclick="window.history.back()">
                <input class="btn btn-primary" style="float: right" type="submit" value="UPDATE">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
            </form>
        </div>
    </div>
@endsection