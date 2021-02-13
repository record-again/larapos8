@extends('admin.dashboard')

@section('title', 'List Barang')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" style="float: right;" href="/formbarang">TAMBAH BARANG</a><br><br><br>
        </div>
            <form action="/barang" method="get">
                <div class="col-md-3 form-group">
                    <input class="form-control" type="text" name="bsrc" placeholder="Search">
                </div>
                <div class="col-md-1"><input class="btn btn-success" type="submit" value="Search"></div>
                <div class="col-md-8">
                    @foreach ($kategori as $item)
                        <a class="btn btn-warning" href="/barang?cat={{ $item->id_kategori }}">{{ $item->nama_kategori }}</a>
                    @endforeach
                </div>
            </form>
        @if (Session::get('pesaninput'))
        <div class="col-md-12 alert alert-success">{{ Session::get('pesaninput') }}</div>
        @elseif (Session::get('pesanupdate'))
        <div class="col-md-12 alert alert-success">{{ Session::get('pesanupdate') }}</div>
        @elseif (Session::get('pesandelete'))
            <div class="col-md-12 alert alert-danger">{{ Session::get('pesandelete') }}</div>
        @endif
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">List Barang</div>
            <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Harga</th>
                        <th colspan="2">Action</th>
                    </tr>
                @foreach ($barang as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>{{ $item->stok_barang }}</td>
                        <td>{{ $item->terjual }}</td>
                        <td>Rp. @currency($item->harga_barang)</td>
                        <td>
                            <a class="btn btn-success" href="/barang/{{ $item->id_barang }}/edit">EDIT</a>
                        </td>
                        <td>
                            <form action="/delbarang/{{ $item->id_barang }}" method="post">
                                <input class="btn btn-danger" type="submit" value="DELETE">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
                
            </table>
    </div>
    <div class="row">
        <div class="col-md-12">{{ $barang->links() }}</div>
    </div>
@endsection