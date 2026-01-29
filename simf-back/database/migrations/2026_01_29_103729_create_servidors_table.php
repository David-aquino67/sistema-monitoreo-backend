<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servidores', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('ip')->nullable();
            $table->string('ubicacion');
            $table->enum('estado', ['online', 'offline', 'warning'])->default('online');
            $table->integer('latencia')->default(0);
            $table->string('tiempoActividad')->default('0d 0h');
            $table->timestamp('ultimoPing')->nullable();
            $table->json('permisos')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servidors');
    }
};
