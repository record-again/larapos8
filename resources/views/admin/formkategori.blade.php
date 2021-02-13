@extends('admin.dashboard')

@section('title', 'Tambah Kategori')

@section('content')
    <h1>Tambah Kategori</h1>
    <form action="/addcat" method="post">
        <div class="form-group">
            <input class="form-control" type="text" name="nama_kategori" value="{{ old('nama_kategori') }}">
            @error('nama_kategori')
                <div class="alert alert-danger" style="margin: 10px 0">{{ $message }}</div>
            @enderror
        </div>
        <input class="btn btn-warning" type="button" onclick="window.history.back()" value="BACK">
        <input class="btn btn-primary" style="float: right" type="submit" value="SUBMIT">
        {{ csrf_field() }}
    </form>
@endsection