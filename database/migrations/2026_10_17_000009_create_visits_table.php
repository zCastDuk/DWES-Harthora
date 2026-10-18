<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->time('time_slot');
            $table->enum('status', ['pending', 'confirmed', 'completed'])->default('pending');
            $table->timestamps();

            $table->unique(['property_id', 'date', 'time_slot']);
            $table->unique(['agent_id', 'date', 'time_slot']);
            $table->unique(['client_id', 'date', 'time_slot']);  // un cliente no puede estar en dos visitas a la vez
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
