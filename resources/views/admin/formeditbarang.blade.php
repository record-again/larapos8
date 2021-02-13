@extends('admin.dashboard')

@section('title', 'Edit Barang')

@section('content')
    <h1>Edit Barang</h1>
    <form action="/updatebarang/{{ $barang->id_barang }}" method="post">
        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
        <div class="form-group">
            <label for="">Nama Barang</label>
            <input class="form-control" type="text" name="nm_barang" value="{{ $barang->nama_barang }}">
        </div>
        <div class="form-group">
            <label for="">Harga</label>
            <input class="form-control" type="text" name="harga_barang" value="{{ $barang->harga_barang }}">
        </div>
        <div class="form-group">
            <label for="">Deskripsi Barang</label>
            <textarea class="form-control" name="deskripsi_barang" id="" cols="30" rows="10">{{ $barang->desc_barang }}</textarea>
        </div>
        <div class="form-group">
            <label for="">Stok</label>
            <input class="form-control" type="text" name="stok_barang" value="{{ $barang->stok_barang }}">
        </div>
        <div class="form-group">
            <label for="">Kategori</label>
            <select class="form-control" name="id_kategori" id="">
                @foreach ($kategori as $item)
                    @if ($barang->id_kategori == $item->id_kategori)
                        <option value="{{ $item->id_kategori }}" selected>{{ $item->nama_kategori }}</option>
                    @else 
                        <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>   
                    @endif
                @endforeach
            </select>
        </div>
        <input class="btn btn-warning" type="button" value="BACK" onclick="window.history.back()">
        <input class="btn btn-primary" style="float: right" type="submit" value="UPDATE">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
    </form>
@endsection