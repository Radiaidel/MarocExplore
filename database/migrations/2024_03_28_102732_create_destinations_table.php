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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('itineraire_id');
            $table->foreign('itineraire_id')->references('id')->on('itineraires')->onDelete('cascade');
            $table->string('name');
            $table->string('accommodation');
            $table->json('activities');
            $table->json('places_to_visit');
            $table->json('dishes_to_try');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
