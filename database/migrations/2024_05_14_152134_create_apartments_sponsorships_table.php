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
        Schema::create('apartments_sponsorships', function (Blueprint $table) {
            $table->foreignId('apartment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sponsorship_id')->constrained()->cascadeOnDelete();
            $table->date('start_sponsorship');
            $table->date('end_sponsorship');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments_sponsorships');
    }
};
