@extends('admin.dashboard')

@section('title', 'Tambah Barang')

@section('content')
    <h1>Tambah Barang</h1>
    <form action="/addbarang" method="post">
        <div class="form-group">
            <label for="">Kode Barang</label>
            <input id="formkode-barang" class="form-control" type="text" name="id_barang" placeholder="Kode Barang" value="{{ old('id_barang') }}">
            <span id="alert-codeval"></span>
            @error('id_barang')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Nama Barang</label>
            <input class="form-control" type="text" name="nama_barang" placeholder="Nama Barang" value="{{ old('nama_barang') }}">
            @error('nama_barang')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Harga</label>
            <input class="form-control" type="text" name="harga_barang" placeholder="Harga Barang" value="{{ old('harga_barang') }}">
            @error('harga_barang')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea class="form-control" name="deskripsi_barang" id="" cols="30" rows="10" placeholder="Deskripsi Barang">{{ old('deskripsi_barang') }}</textarea>
            @error('deskripsi_barang')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Stok</label>
            <input class="form-control" type="text" name="stok_barang" placeholder="Stok Barang" value="{{ old('stok_barang') }}">
            @error('stok_barang')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Kategori</label>
            <select class="form-control" name="id_kategori" id="">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <input class="btn btn-warning" type="button" value="BACK" onclick="window.history.back()">
        <span id="btn-submitbarang"><input class="btn btn-primary" style="float: right" type="submit" value="SUBMIT"></span>
        {{ csrf_field() }}
    </form>
@endsection