<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detailTransaksiPenjualans', function (Blueprint $table) {
            $table->id(); // ID detail transaksi penjualan
            $table->unsignedBigInteger('id_menu'); // Foreign key ke tabel menu
            $table->unsignedBigInteger('id_transaksi_penjualan'); // Foreign key ke tabel transaksiPenjualans
            $table->integer('jumlah_menu'); // Jumlah menu yang dibeli
            $table->float('total_harga_per_menu'); // Total harga per menu
            $table->timestamps();

            // Set foreign key constraints
            $table->foreign('id_menu')->references('id')->on('menus')->onDelete('restrict');
            $table->foreign('id_transaksi_penjualan')->references('id')->on('transaksi_penjualans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailTransaksiPenjualans');
    }
};
