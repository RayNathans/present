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
            Schema::create('members', function (Blueprint $table) {
                $table->id();
                $table->string('nama_member');
                $table->float('diskon_member')->unique();
                $table->float('batas_atas_member')->nullable();
                $table->float('batas_bawah_member')->nullable();
                $table->rememberToken();
                $table->timestamps();
                // $table->foreignId('current_team_id')->nullable();
                // $table->string('profile_photo_path', 2048)->nullable();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('members');
        }
    };
