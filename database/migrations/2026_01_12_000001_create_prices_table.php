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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', 255);
            $table->string('duration', 50)->nullable();
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('icon', 100)->default('fa-solid fa-star');
            $table->integer('order')->default(0);
        });

        // Insert default pricing data
        DB::table('prices')->insert([
            ['service_name' => 'Individuální fyzioterapie', 'duration' => '30 min', 'price' => 600, 'icon' => 'fa-solid fa-person-walking', 'order' => 1],
            ['service_name' => 'Individuální fyzioterapie', 'duration' => '60 min', 'price' => 1200, 'icon' => 'fa-solid fa-person-walking', 'order' => 2],
            ['service_name' => 'Přístrojová lymfodrenáž', 'duration' => '30 min', 'price' => 150, 'icon' => 'fa-solid fa-spa', 'order' => 3],
            ['service_name' => 'Přístrojová lymfodrenáž', 'duration' => '60 min', 'price' => 300, 'icon' => 'fa-solid fa-spa', 'order' => 4],
            ['service_name' => 'Manuální lymfodrenáž', 'duration' => '60 min', 'price' => 1200, 'icon' => 'fa-solid fa-spa', 'order' => 5],
            ['service_name' => 'Vojtova reflexní terapie', 'duration' => '60 min', 'price' => 1200, 'icon' => 'fa-solid fa-person-dots-from-line', 'order' => 6],
            ['service_name' => 'Elektroterapie', 'duration' => null, 'price' => 100, 'icon' => 'fa-solid fa-bolt', 'order' => 7],
            ['service_name' => 'Tejpování', 'duration' => 'Nalepení', 'price' => 100, 'icon' => 'fa-solid fa-tape', 'order' => 8],
            ['service_name' => 'Tejpování', 'duration' => 'Použitý materiál à 1cm', 'price' => 1.50, 'icon' => 'fa-solid fa-tape', 'order' => 9],
            ['service_name' => 'Potvrzení pro pojišťovnu', 'duration' => null, 'price' => 100, 'icon' => 'fa-solid fa-check-to-slot', 'order' => 10],
            ['service_name' => 'Dárkové poukazy', 'duration' => null, 'price' => 500, 'description' => 'od 500 Kč', 'icon' => 'fa-solid fa-hand-holding-heart', 'order' => 11],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};

