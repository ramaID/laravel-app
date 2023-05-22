<?php

use Domain\Stock\SeriEnum;
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
        Schema::create('old_stocks', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('no_seri', 12)->index();
            $table->enum('tipe_seri', SeriEnum::keys());
            $table->string('nama_registrasi')->index();
            $table->string('kelompok')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_stocks');
    }
};
