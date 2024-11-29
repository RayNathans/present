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
            Schema::create('detailPembelians', function (Blueprint $table) {
                $table->id(); // ID detail pembelian
                $table->unsignedBigInteger('id_bahan_baku'); // Foreign key ke tabel bahanbakus
                $table->integer('jumlah_per_bahan_baku'); 
                $table->float('total_harga_per_bahan_baku');
                $table->unsignedBigInteger('id_transaksi_beli'); // Foreign key ke tabel transaksiPembelians
                $table->timestamps();
            
                // Set foreign key constraints
                $table->foreign('id_bahan_baku')->references('id')->on('bahanbakus')->onDelete('restrict');
                $table->foreign('id_transaksi_beli')->references('id')->on('transaksiPembelians')->onDelete('cascade');
            });
        }
        
        

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('detailPembelians');
        }
    };
