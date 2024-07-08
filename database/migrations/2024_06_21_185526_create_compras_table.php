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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->default(1);
            $table->foreignId('user_id');
            $table->string('titulo');
            //$table->string('full_titulo')->virtualAs('concat(titulo, \' \', fecha_compra)');
            $table->string('descripcion');
            $table->date('fecha_compra');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
