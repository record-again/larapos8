@extends('admin.dashboard')

@section('title', 'Grafik Penjualan')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Grafik Penjualan Bulanan</div>
        <div class="panel-body">
            <canvas id="chart-bulan" width="400" height="100"></canvas>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Grafik Barang Terjual</div>
        <div class="panel-body">
            <canvas id="barang-jual" width="400" style="height: auto;"></canvas>
        </div>
    </div>
    <script type="text/javascript" src="/js/chart.min.js"></script>
    <script type="text/javascript" src="/js/grafik.js"></script>
@endsection