<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('province');
            $table->string('country');
            $table->timestamps();

            $table->index('neighborhood');
            $table->index(['city', 'province']);
            $table->unique(['city', 'province', 'neighborhood', 'country']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
