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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('cif', 20)->unique();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('type');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
