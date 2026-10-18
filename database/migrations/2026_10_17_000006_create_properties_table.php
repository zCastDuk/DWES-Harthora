<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')->constrained()->restrictOnDelete();
            $table->foreignId('agent_id')->constrained()->restrictOnDelete();
            $table->foreignId('zone_id')->constrained()->restrictOnDelete();

            $table->string('title');
            $table->text('description');
            $table->enum('type', ['villa', 'chalet', 'penthouse', 'flat', 'country_house']);
            $table->decimal('price', 12, 2);
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->decimal('usable_area', 8, 2);
            $table->decimal('built_area', 8, 2);


            $table->string('address');
            $table->string('postal_code', 10);          // código postal: texto, para no perder ceros (03001)

            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');

            $table->boolean('is_exclusive')->default(false); // true = solo la ven clientes premium
            $table->date('portfolio_entry_date');
            $table->timestamp('published_at')->nullable();

            $table->index('type');
            $table->index('price');
            $table->index('status');
            $table->index('published_at');

            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('properties');
}
};
