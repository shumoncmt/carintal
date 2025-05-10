<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_cars_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // BIGINT
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('car_type'); // SUV, Sedan, etc.
            $table->decimal('daily_rent_price', 8, 2);
            $table->boolean('availability')->default(true); // Available/Not Available (general status)
            $table->string('image')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
