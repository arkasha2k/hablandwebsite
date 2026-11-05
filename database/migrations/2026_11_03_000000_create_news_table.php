<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 🆕 НОВЫЙ ФАЙЛ: database/migrations/2026_11_03_000000_create_news_table.php
 Таблица новостей в стиле Arcturus (integer id, unixtime без created_at/updated_at).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');                 // INT AUTO_INCREMENT (как item_id в Arcturus)
            $table->string('title');                  // заголовок
            $table->text('body');                     // текст новости
            $table->string('image')->nullable();      // ссылка на картинку (пока не используется)
            $table->string('category', 30)->default('event'); // event | update | contest
            $table->boolean('featured')->default(false);      // показывать крупно на главной
            $table->unsignedInteger('created_at_int')->default(0); // unixtime публикации
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
