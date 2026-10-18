<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            //Un agente puede ser commercial, financiero o directivo.
            //Bifurcación en comercial: novato y senior. Calculable
            $table->enum('role', ['commercial', 'financial', 'management']);
            $table->date('hire_date');
            $table->index('role');
            $table->timestamps();
        });

    }

    public function down(): void{
        Schema::dropIfExists('agents');
    }
};
