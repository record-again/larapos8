<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreteBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('nama_barang', 255);
            $table->string('harga_barang', 255);
            $table->text('desc_barang')->nullable($value = true);
            $table->integer('stok_barang');
            $table->integer('terjual');
            $table->integer('id_kategori')->unsigned();
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
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
