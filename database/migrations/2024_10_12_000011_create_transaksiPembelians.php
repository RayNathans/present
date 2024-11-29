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
        Schema::create('transaksiPembelians', function (Blueprint $table) {
            $table->id(); // ID transaksi penjualan
            $table->unsignedBigInteger('id_user'); // Foreign key ke tabel users
            // $table->unsignedBigInteger('id_bahan_bakus'); // Foreign key ke tabel pelanggans
            $table->float('total_harga');
            $table->timestamps();
            $table->date('tanggal_transaksi');
    
            // Set foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('id_bahan_bakus')->references('id')->on('bahanbakus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksiPembelians');
    }
};
