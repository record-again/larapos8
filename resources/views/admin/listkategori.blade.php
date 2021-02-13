@extends('admin.dashboard')

@section('title', 'Kategori')

@section('content')
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" style="float: right;" href="/formcat">TAMBAH KATEGORI</a><br><br><br>
    </div>
    @if (Session::get('pesaninput'))
        <div class="col-md-12 alert alert-success">{{ Session::get('pesaninput') }}</div>
    @elseif (Session::get('pesanupdate'))
        <div class="col-md-12 alert alert-success">{{ Session::get('pesanupdate') }}</div>
    @elseif (Session::get('pesandelete'))
        <div class="col-md-12 alert alert-danger">{{ Session::get('pesandelete') }}</div>
    @endif
</div>
    <div class="panel panel-default">
        <div class="panel-heading">List Kategori</div>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th colspan="2">Action</th>
            </tr>
        @foreach ($kategori as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>
                        <a class="btn btn-success" href="/kategori/{{ $item->id_kategori }}/edit">EDIT</a>
                    </td>
                    <td>
                        <form action="/delcat/{{ $item->id_kategori }}" method="post">
                            <input class="btn btn-danger" type="submit" value="DELETE">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                        </form>
                    </td>
                </tr>
        @endforeach
        </table>
    </div>
@endsection