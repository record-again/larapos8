<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barnag');
            $table->string('nama_barang', 255);
            $table->string('harga_barang', 255);
            $table->text('desc_barang')->nullable($value = true);
            $table->integer('stok_barang', 11);
            $table->integer('terjual', 11);
            $table->integer('id_kategori', 11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
