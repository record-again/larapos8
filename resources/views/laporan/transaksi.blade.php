{{-- <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"> --}}
<title>Laporan Transaksi Bulan {{ $from }} - {{ $to }} #{{ $year }}</title>
<style>
    .container{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;width:100%}.panel-default{border-color:#ddd}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}.panel-default>.panel-heading{color:#333;background-color:#f5f5f5;border-color:#ddd}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px}table{background-color:transparent;border-collapse:collapse;border-spacing:0;font-size:.6rem}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}th{text-align:left}
</style>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Laporan Transaksi Bulan {{ $from }} - {{ $to }} #{{ $year }}</div>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Kode Transaksi</th>
                <th>Pembeli</th>
                <th>Total Belanja</th>
                <th>Uang Bayar</th>
                <th>Uang Kembali</th>
                <th>Barang</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
            @foreach ($transaksi as $item)
                @php 
                    ($item->status == 'Tunda') ? $block = "class='danger'" : $block = null;
                @endphp
                        <tr @php echo $block @endphp>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->id_transaksi }}</td>
                            <td>{{ $item->nama_pembeli }}</td>
                            <td>Rp.@currency($item->total_bayar)</td>
                            <td>Rp.@currency($item->uang_bayar)</td>
                            <td>Rp.@currency($item->uang_kembali)</td>
                            <td>
                                <table>
                                    @php
                                        $barang = json_decode($item->json_barang);
                                        foreach ($barang as $row):
                                    @endphp
                                    <tr>
                                        <td>{{ $row->nmbarang }}&nbsp;</td>
                                        <td>Rp.@currency($row->harga)</td>
                                        <td>&nbsp;x&nbsp;</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>&nbsp;=&nbsp;</td>
                                        <td>Rp.@currency($row->subtotal)</td>
                                    </tr>
                                    @php endforeach; @endphp
                                </table>
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>{{ date('F d, Y  h:i:s', strtotime($item->created_at)) }}</td>
                        </tr>
                @endforeach
        </table>
    </div>
</div>