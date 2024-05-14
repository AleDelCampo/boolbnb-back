<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->tinyInteger('n_rooms');
            $table->tinyInteger('n_beds');
            $table->tinyInteger('n_bathrooms');
            $table->smallInteger('squared_meters');
            $table->text('image')->nullable();
            $table->boolean('is_visible');
            $table->text('description')->nullable();
            $table->string('address');
            $table->decimal('latitude');
            $table->decimal('longitude');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
