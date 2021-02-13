function monthName(mon) {
    return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'][mon - 1];
 }


$.getJSON('/datachart', function(data) {
    var bulan = [];
    var pendapatan = [];
    var uang = [];
    $.each(data, function(index, val) {
        bulan.push(monthName(val.bulan));
        pendapatan.push(val.pendapatan);
        uang.push(addCommas(val.pendapatan));
    });

    new Chart($("#chart-bulan"), {
        "type": "line",
        "data": {
            "labels": bulan,
            "datasets": [{
                "label": "Pendapatan",
                "data": pendapatan,
                "fill": false,
                "borderColor": "rgb(0, 128, 128)",
                "lineTension": 0.1
            }]
        },
        "options": {
                        "responsive": true,
                        "tooltips": {
                            "callbacks": {
                                "label": function(t, d) {
                                            var xLabel = d.datasets[t.datasetIndex].label;
                                            var yLabel = t.yLabel >= 1000 ? 'IDR' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'IDR' + t.yLabel;
                                            return xLabel + ': ' + yLabel;
                                         }
                            }
                        }
            }
    });
});

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$.getJSON('/datasell', function(datajual) {
    var nama = [];
    var qty = [];
    var color = [];
    $.each(datajual, function(index, val) {
        nama.push(val.nama_barang);
        qty.push(val.terjual);
        color.push(getRandomColor());
    });

    new Chart($("#barang-jual"), {
        "type": "horizontalBar",
        "data": {
            "labels": nama,
            "datasets": [{
                "label": "Terjual",
                "data": qty,
                "fill": false,
                "backgroundColor": color
            }]
        },
        "options": {
            "scales": {
                "xAxes": [{
                    "ticks": {
                        "beginAtZero": true
                    }
                }]
            },
            "responsive": true
        }
    });

});