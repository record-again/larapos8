function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function jumlahBayar() {
    var td = $("td#sub-total");
    var jumlah = 0;
    for(var i =0; i<td.length; i++) {
        jumlah += parseFloat(td[i].dataset.value);
    }

    return jumlah;
}

function totalBayar() {
    var jumlah_bayar = jumlahBayar();
    $("#total-bayar").attr('data-value', jumlah_bayar);
    $("#total-bayar").text(addCommas(jumlah_bayar));

    return true;
}

$("#formkode-barang, #txtbayar, #src_kode").keyup(function() {
    var val = $(this).val();
    val = val.replace(/[^0-9\.]/g,'');
    $(this).val(val);
});

$("#keranjang").on( 'keyup', '#txtqty',function() {
    var val = $(this).val();
    val = val.replace(/[^0-9\.]/g,'');
    $(this).val(val);
});

function kembali() {
    var uang = $("#txtbayar").val();
    var total = $("#total-bayar").attr('data-value');
    var kembali = parseInt(total) - parseInt(uang)
    if(uang == '' || uang == 0) { kembali = 0; }
    $("#uang-kembali").attr('data-value', kembali);
    $("#uang-kembali").html("<b>"+addCommas(kembali)+"</b>");
}

$('#src_kode').change(function() {  
    var query = $(this).val();
    var token = $("input[name='_token']").val();
    if(query != '') {
        $.ajax({  
            url:"/kdsearch",  
            method:"POST",  
            data: {"_token": token, "srcdata": query },  
            success:function(data) {
                if(data[0].stok_barang <= 0) {
                    alertMsg("Stok tidak cukup !!");
                }
                else if(data != '') {
                    if($("#keranjang").find("#kode-"+data[0].id_barang).length == 1) {
                        var beqty = parseFloat($("#kode-"+data[0].id_barang).find("#txtqty").val());
                        var afqty = beqty + 1;
                        $("#kode-"+data[0].id_barang).find("#txtqty").val(afqty);
                        var qty = $("#kode-"+data[0].id_barang).find("#txtqty").val();
                        var tr = $("#kode-"+data[0].id_barang).parent();
                        var harga = tr.find('#tab_harga').attr('data-value');
                        jumlah = parseInt(harga) * parseInt(qty);
                        tr.find("#sub-total").attr("data-value", jumlah);
                        tr.find("#sub-total").text(addCommas(jumlah));
                        totalBayar();
                        $("#src_kode").val('');
                        $("#kode-"+data[0].id_barang).append("<span class='balon-qty'></span>");
                        $("#kode-"+data[0].id_barang).find('.balon-qty').text(qty);
                        $("#kode-"+data[0].id_barang).find('.balon-qty').fadeOut(1500, function() { $(this).remove(); });
                        kembali();
                        $("#btn-selesai").hide();
                    }
                    else {
                        $("#keranjang").append("<tr id='item-barang'><td id='idbarang' data-value="+data[0].id_barang+">"+data[0].nama_barang+"<br>Stok: <span class='badge' id='stokbarang'>"+data[0].stok_barang+"</span></td><td data-value="+data[0].harga_barang+" style='text-align: right;' id='tab_harga'>"+addCommas(data[0].harga_barang)+"</td><td>x</td><td class='tooltip-qty' id='kode-"+data[0].id_barang+"'><button id='minusbtn' class='btn btn-danger'>-</button><input id='txtqty' type='text' value='1' size='3'><button id='plusbtn' class='btn btn-danger'>+</button></td><td data-value="+data[0].harga_barang+" style='text-align: right;' id='sub-total'>"+addCommas(data[0].harga_barang)+"</td><td class='hapus-item'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td></tr>");
                        totalBayar();
                        kembali();
                        $("#src_kode").val('');
                        $("#btn-selesai").hide();
                    }
                }
                else {
                    $("#src_kode").val('');
                    alert("Coba Lagi !!!");
                }
                
            }  
        });  
    }  
});

function currentLi() {
    var li = $("#suggest").find("li");
    if($("#suggest").find(".block").length > 0 ) {
        for(var i = 0; i<li.length; i++) {
            if(li[i].className == 'block') {
                break;
            }
        }
    }
    return i;
}

function nextLi() {
    var li = $("#suggest").find("li");
    if($("#suggest").find(".block").length > 0 ) {
        for(var i = 0; i<li.length; i++) {
            if(li[i].className == 'block') {
                var next = i + 1;
                break;        
            }
        }
    }
    var max = li.length - 1;
    if(next > max) {
        next = 0;
    }
    return next;
}

function prevLi() {
    var li = $("#suggest").find("li");
    if($("#suggest").find(".block").length > 0 ) {
        for(var i = 0; i<li.length; i++) {
            if(li[i].className == 'block') {
                var prev = i - 1;
                break;        
            }
        }
    }

    if(prev < 0) {
        prev = 0;
    }
    return prev;
}

function addCart(produk, objitem) {
    if($("#keranjang").find("#kode-"+objitem.idbarang).length == 1) {
        var beqty = parseFloat($("#kode-"+objitem.idbarang).find("#txtqty").val());
        var afqty = beqty + 1;
        $("#kode-"+objitem.idbarang).find("#txtqty").val(afqty);
        var qty =   $("#kode-"+objitem.idbarang).find("#txtqty").val();
        var tr = $("#kode-"+objitem.idbarang).parent();
        var harga = tr.find('#tab_harga').attr('data-value');
        jumlah = parseInt(harga) * parseInt(qty);
        tr.find("#sub-total").attr("data-value", jumlah);
        tr.find("#sub-total").text(addCommas(jumlah));
        totalBayar();
        $("#kode-"+objitem.idbarang).append("<span class='balon-qty'></span>");
        $("#kode-"+objitem.idbarang).find('.balon-qty').text(qty);
        $("#kode-"+objitem.idbarang).find('.balon-qty').fadeOut(1500, function() { $(this).remove(); });
        kembali();
        $("#btn-selesai").hide();
    }
    else {
        $("#keranjang").append("<tr id='item-barang'><td id='idbarang' data-value="+objitem.idbarang+">"+produk+"<br>Stok: <span class='badge' id='stokbarang'>"+objitem.stok+"</span></td><td data-value="+objitem.harga+" style='text-align: right;' id='tab_harga'>"+addCommas(objitem.harga)+"</td><td>x</td><td class='tooltip-qty' id='kode-"+objitem.idbarang+"'><button id='minusbtn' class='btn btn-danger'>-</button><input id='txtqty' type='text' value='1' size='3'><button id='plusbtn' class='btn btn-danger'>+</button></td><td data-value="+objitem.harga+" style='text-align: right;' id='sub-total'>"+addCommas(objitem.harga)+"</td><td class='hapus-item'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td></tr>");
        totalBayar();
        $("#btn-selesai").hide();
    }
    $("#suggest").fadeOut();
}

function alertMsg(message) {
    var alertEl = "<div class='alert alert-danger' role='alert'><h4>"+message+"</h4></div>";
    $("#alert-box").append(alertEl);
    $(".alert").fadeOut(3000, function() { $(this).remove(); })
}

function limitStok(el) {
    var stok = el.parent().find("#stokbarang").text();
    return stok;
}

$("#keranjang").on('click', '#plusbtn', function() {
    var btn = $(this).parent();
    var qty = btn.find('#txtqty').val();
    qty = parseInt(qty) + 1;
    if(limitStok(btn) >= qty) {
        btn.find('#txtqty').val(qty);
        var harga = btn.parent().find("#tab_harga").attr("data-value");
        var jumlah = parseInt(harga) * qty;
        btn.parent().find("#sub-total").attr("data-value", jumlah);
        btn.parent().find("#sub-total").text(addCommas(jumlah));
        totalBayar();
        kembali();
        $("#btn-selesai").hide();
    }
    else {
        alertMsg("Stok tidak cukup !!");
    }
    
    
    return true;
});

$("#keranjang").on('click', '#minusbtn', function() {
    var btn = $(this).parent();
    var qty = btn.find('#txtqty').val();
    qty = parseInt(qty) - 1;
    if(qty < 1) { qty = 1}
    btn.find('#txtqty').val(qty);
    var harga = btn.parent().find("#tab_harga").attr("data-value");
    var jumlah = parseInt(harga) * qty;
    btn.parent().find("#sub-total").attr("data-value", jumlah);
    btn.parent().find("#sub-total").text(addCommas(jumlah));
    totalBayar();
    kembali();
    $("#btn-selesai").hide();
    
    return true;
});

$('#src_kasir').keyup(function(event) {
    var li = $("#suggest").find("li");
    if ( event.which != 40 && event.which != 38 && event.which != 13  ) {
        var query = $(this).val();
        var token = $("input[name='_token']").val();
        if(query != '') {
            $.ajax({  
                url:"/search",  
                method:"POST",  
                data: {"_token": token, "srcdata": query },  
                success:function(data) {
                var item = '';
                $.each(data, function(key, val) {
                    var objbarang = JSON.stringify({ idbarang: val.id_barang, harga: val.harga_barang, stok: val.stok_barang });
                    item +="<li data-value="+objbarang+">"+val.nama_barang+"</li>";
                });
                $("#suggest").fadeIn();
                $("#suggest").html(item);
                }  
            });  
        }
    }
    else if ( event.which == 40 && li.length > 0 ) {
        var cblock = $("#suggest").find(".block").length;
            if(cblock == 0) {
                li[0].className = 'block';     
            }
            else {
                li[nextLi()].className = 'block';
                li[currentLi()].className = '';
            }
            
     }
     else if( event.which == 38 && li.length > 0 ) {
        var cblock = $("#suggest").find(".block").length;
            if(cblock == 0) {
                li[0].className = 'block';     
            }
            else {
                li[prevLi()].className = 'block';
                li[currentLi() + 1].className = '';
            }
     }
     else if( event.which == 13 && li.length > 0 ) {
        if( $(".sugstyle").find('.block').length > 0 ) {
            var produk = $(".block")[0].textContent;
            var objecProduk = $(".block")[0].dataset.value;
            var objitem = JSON.parse(objecProduk);
            if(objitem.stok > 0) {
                addCart(produk, objitem);
                $("#suggest").fadeOut();
                $(this).val('');
            }
            else {
                alertMsg("Stok tidak cukup !!");
                $("#suggest").fadeOut();
                $(this).val('');
            }
        }
        
     }
     else { return true; }
});

$('#suggest').on('click', 'li', function() {
    var produk = $(this).text();
    $("#src_kasir").val(produk);
    var objitem = JSON.parse($(this).attr('data-value'));
    if(objitem.stok > 0) {
        addCart(produk, objitem);
        $("#suggest").fadeOut();
    }
    else {
        alertMsg("Stok tidak cukup !!");
        $("#suggest").fadeOut();
    }
});

$("#keranjang").on('keyup', '#txtqty', delay(function() {
    var nilai = $(this).val();
    if(limitStok($(this).parent()) >= parseInt(nilai)) {
        var row = $(this).parent().parent();
        var jumlah = row.find("#tab_harga").attr('data-value');
        jumlah = parseInt(jumlah) * parseInt(nilai);
        row.find("#sub-total").attr("data-value", jumlah);
        row.find("#sub-total").text(addCommas(jumlah));
        totalBayar();
    }
    else {
        alertMsg("Stok tidak cukup !!");
        $(this).val(limitStok($(this).parent()));
    }
}, 1000));

$("#keranjang").on('click', '.hapus-item', function() {
    var tr = $(this).parent("tr").remove();
    totalBayar();
});

$("#txtbayar").click(function() {
    $(this).val('');
});

$("#txtbayar").change(function() {
    kembali()
    $("#btn-selesai").show();
});

$("#btn-bayar").click(function() {
    kembali()
    $("#btn-selesai").show();
    $("#txt-namatun").hide();
});

$("#btn-tunda").click(function() {
   $("#txt-namatun").show();
});

$("#txt-namatun").keyup(function() {
    if($(this).val() == '') {
        $("#btn-selesai").hide();
    }
    else {
        $("#btn-selesai").show();
    }
});

function printData(kode, dataprint, total, bayar, kembali) {
    var chart = JSON.parse(dataprint);
    var html = "<b>My Store</b> #"+kode+"<hr><table>";
    html += ""
    $.each(chart, function(index, val) {
        html += "<tr><td>"+val.nmbarang+"</td><td>Rp."+addCommas(val.harga)+"</td><td>x</td><td>"+val.qty+"</td><td>=</td><td>Rp."+addCommas(val.subtotal)+"</td></tr>";
    });
    html += "<table><hr><b>Total : Rp."+addCommas(total)+"</b><br><br>Uang Bayar : Rp."+addCommas(bayar)+"  Kembali : Rp."+addCommas(kembali);

    newWin= window.open("");
    newWin.document.write(html);
    newWin.print();
    newWin.close();
}

$("#btn-selesai").click(function() {
    var uangbayar = $("#txtbayar").val();

    if(uangbayar > 0) {
        var nama = 'Umum';
        var status = 'Lunas';
    }
    else {
        var nama = $("#txt-namatun").val();
        var status = 'Tunda';
    }

    if(uangbayar == '') { uangbayar = 0}

    var produk = $("#keranjang").find("*#idbarang");
    var harga = $("#keranjang").find("*#tab_harga");
    var qty = $("#keranjang").find("*#txtqty");
    var subtotal = $("#keranjang").find("*#sub-total");
    var totalbayar = $("#total-bayar").attr("data-value");
    var uangkembali = $("#uang-kembali").attr('data-value');
    var arrprod = [];
    for(var i = 0; i<produk.length; i++) {
        arrprod[i] = { "idbarang": produk[i].dataset.value,
                        "nmbarang": produk[i].firstChild.data,
                        "harga": harga[i].dataset.value,
                        "qty": qty[i].value,
                        "subtotal": subtotal[i].dataset.value
                        };
    }
    arrprod = JSON.stringify(arrprod);
    var token = $("input[name='_token']").val();
    $.ajax({
        type: "POST",
        url: '/transaksi',
        dataType: 'JSON',
        data: {"_token": token, "nama": nama, "totalbayar":totalbayar, "uangbayar": uangbayar, "uangkembali": uangkembali, "barang": arrprod, "status": status },
        statusCode: {
            500: function() {
              console.log('slow');
            }
          },
      }).done(function(response) {
        $("*#item-barang").remove();
        $("#total-bayar").val(0);
        $("#txtbayar").val(0);
        $("#uang-kembali").text(0);
        $("#txt-namatun").val('');
        /*if(status == 'Lunas') { printData(response, arrprod, totalbayar, uangbayar, uangkembali) }*/
        alert("Transaksi Berhasil !!");
      }).fail(function() {
        alert( "error" );
      });
});

$("#formkode-barang").keyup(delay(function() {
    var token = $("input[name='_token']").val();
    var val = $(this).val();
    if(val != '') {
        $.ajax({
            type: 'POST',
            url: '/codeval',
            dataType: 'JSON',
            data: {"_token": token, "kode": val}
        }).done(function(response) {
            if(response == true) {
                $("#formkode-barang").css("border-color", "green");
                $("#alert-codeval").html("<div class='alert alert-success' role='alert' style='margin-top: 8px'>Kode Dapat Digunakan</div>");
                $("#btn-submitbarang").html("<input class='btn btn-primary' style='float: right;' type='submit' value='SUBMIT'>");
            }
            else {
                $("#formkode-barang").css("border-color", "red");
                $("#alert-codeval").html("<div class='alert alert-danger' role='alert' style='margin-top: 8px'>Kode Tidak Dapat Digunakan</div>");
                $("#btn-submitbarang").html("<div class='btn btn-warning disabled' style='float: right;'>PERIKSA KODE BARANG KEMBALI</div>");
            }
        });
    }
}, 500));

$("input[name='stok_barang'], input[name='harga_barang'], input[name='stok_barang']").keyup(function() {
    var val = $(this).val();
    val = val.replace(/[^0-9\.]/g,'');
    $(this).val(val);
});

/* Bootstrap */

$('.dropdown-toggle').dropdown();


