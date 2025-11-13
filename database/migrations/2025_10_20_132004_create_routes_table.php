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
        Schema::create('routes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asal_terminal_id')->constrained('terminals')->onDelete('cascade');
        $table->foreignId('tujuan_terminal_id')->constrained('terminals')->onDelete('cascade');
        $table->integer('jarak_km');
        $table->integer('estimated_duration_minutes');
        $table->decimal('harga_dasar', 10, 2);
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
