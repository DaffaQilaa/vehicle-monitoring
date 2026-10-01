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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->string('name');
            $table->string('license_plate');
            $table->enum('type', ['angkutan_orang', 'angkutan_barang']);
            $table->enum('ownership', ['milik_sendiri', 'sewa']);
            $table->decimal('fuel_consumption', 8, 2)->default(0); // Liter / KM
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->enum('status', ['available', 'in_use', 'in_service'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
