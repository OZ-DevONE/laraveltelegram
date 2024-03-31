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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('chat_id'); // id чата на котором будет работать
            $table->json('bad_words_list')->nullable(); // слова  в  JSON
            $table->boolean('is_feature_active')->default(false); // активации функции
            $table->timestamps();
    
            // Внешний ключ для связи с таблицей users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    
            // Добавляем внешний ключ для связи с таблицей telegram_groups
            $table->foreign('chat_id')->references('id')->on('telegram_groups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
