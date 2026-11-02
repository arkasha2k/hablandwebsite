<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            // одна строка на "сутки" — простой счётчик посещений по дням
            $table->string('day', 10)->primary();          // Y-m-d
            $table->unsignedInteger('hits')->default(0);   // просмотры за день
            $table->unsignedInteger('unique_visitors')->default(0); // уникальные (по fingerprint)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
