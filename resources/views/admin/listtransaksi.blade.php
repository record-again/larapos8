@extends('admin.dashboard')

@section('title', 'Transaksi')

@section('content')
<div class="row">
        <form action="/alltransaksi" method="get">
            <div class="col-md-2">
                <select class="form-control" name="where" id="">
                    @if ($combo == 'kode')
                        <option value="kode" selected>Kode</option>
                        <option value="nama">Nama</option> 
                    @elseif ($combo == 'nama')
                        <option value="kode">Kode</option>
                        <option value="nama" selected>Nama</option>
                    @else
                        <option value="kode">Kode</option>
                        <option value="nama">Nama</option>
                    @endif
                </select>
            </div>
            <div class="col-md-3 form-group">
                <input class="form-control" type="search" name="tsrc" placeholder="Search" value="{{ $oldsrc }}">
            </div>
            <div class="col-md-1"><input class="btn btn-success" type="submit" value="Search"></div>
            <div class="col-md-4">
                <a class="btn btn-primary" href="/alltransaksi?status=Lunas">Lunas</a>
                <a class="btn btn-warning" href="/alltransaksi?status=Tunda">Tunda</a>
            </div>
        </form>
</div>
    <div class="panel panel-default">
        <div class="panel-heading">List Transaksi</div>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Kode Transaksi</th>
                <th>Pembeli</th>
                <th>Total Belanja</th>
                <th>Uang Bayar</th>
                <th>Uang Kembali</th>
                <th>Status</th>
                <th>Waktu</th>
                <th colspan="2">Action</th>
            </tr>
        @foreach ($transaksi as $item)
        @php 
            ($item->status == 'Tunda') ? $block = "class='danger'" : $block = null;
        @endphp
                <tr @php echo $block @endphp>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->id_transaksi }}</td>
                    <td>{{ $item->nama_pembeli }}</td>
                    <td>Rp. @currency($item->total_bayar)</td>
                    <td>Rp. @currency($item->uang_bayar)</td>
                    <td>Rp. @currency($item->uang_kembali)</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ date('F d, Y - h:i:s', strtotime($item->created_at)) }}</td>
                    <td>
                        <a class="btn btn-success" href="/transaksi/{{ $item->id_transaksi }}/edit">EDIT</a>
                    </td>
                    <td>
                        <form action="/deltrans/{{ $item->id_transaksi }}" method="post">
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
        <div class="col-md-12">{{ $transaksi->links() }}</div>
    </div>
@endsection