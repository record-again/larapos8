{{-- <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"> --}}
<title>Laporan Barang Kategori {{ $kategori }}</title>
<style>
    .container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;width:100%}.panel-default{border-color:#ddd}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}.panel-default>.panel-heading{color:#333;background-color:#f5f5f5;border-color:#ddd}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px}table{background-color:transparent;border-collapse:collapse;border-spacing:0;font-size:.6rem}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}th{text-align:left}
</style>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Laporan Barang Kategori {{ $kategori }}</div>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Terjual</th>
                <th>Harga</th>
            </tr>
            @foreach ($barang as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->stok_barang }}</td>
                    <td>{{ $item->terjual }}</td>
                    <td>Rp. @currency($item->harga_barang)</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>