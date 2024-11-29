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
        Schema::create('transaksi_penjualans', function (Blueprint $table) {
            $table->id(); // ID transaksi penjualan
            $table->unsignedBigInteger('id_user'); // Foreign key ke tabel users
            $table->unsignedBigInteger('id_pelanggan')->nullable(); // Foreign key ke tabel pelanggan
            $table->decimal('total_harga', 10, 2); // Total harga dari transaksi
            $table->string('nomor_meja', 10)->nullable(); // Nomor meja dengan panjang maksimum 10 karakter
            $table->string('status')->default('pending'); // Status transaksi: pending, paid, cancelled
            $table->dateTime('tanggal_transaksi')->useCurrent(); // Tanggal transaksi
            $table->timestamps();

            // Set foreign key constraints
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualans');
    }
};