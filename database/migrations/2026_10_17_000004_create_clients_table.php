<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // foreignId('user_id')  -> columna numérica para guardar el id del usuario
            // ->unique()            -> no puede haber dos clientes con el mismo usuario (eso hace el 1:1)
            // ->constrained()       -> Laravel deduce que apunta a `users.id` y crea la clave foránea
            // ->cascadeOnDelete()   -> si se borra el usuario, se borra también su perfil de cliente
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nif', 20)->unique();
            $table->string('tax_address');

            $table->boolean('is_premium')->default(false); // true = cliente premium

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
