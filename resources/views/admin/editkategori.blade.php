@extends('admin.dashboard')

@section('title', 'Edit Kategori')

@section('content')
    <h1>Edit Kategori</h1>
    <form action="/updatecat/{{ $kategori->id_kategori }}" method="post">
        <div class="form-group">
            <label for="">Nama Kategori</label>
            <input class="form-control" type="text" name="nm_cat" value="{{ $kategori->nama_kategori }}">
        </div>
        <input class="btn btn-warning" type="button" value="BACK" onclick="window.history.back()">
        <input class="btn btn-primary" style="float: right" type="submit" value="UPDATE">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
    </form>
@endsection