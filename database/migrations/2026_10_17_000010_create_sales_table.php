<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->restrictOnDelete();
            $table->foreignId('client_id')->constrained()->restrictOnDelete();
            $table->foreignId('agent_id')->constrained()->restrictOnDelete();
            $table->foreignId('validated_by')->nullable()->constrained('agents')->restrictOnDelete();
            // Precio por el que se vende. Copia del precio de la casa en el momento de la venta,
            // para que no cambie aunque luego se modifique el precio en properties
            $table->decimal('price', 12, 2);
            $table->enum('payment_method', ['transfer', 'mortgage', 'cash']);
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('resolved_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
