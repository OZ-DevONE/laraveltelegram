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
        Schema::create('telegram_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Добавляем колонку user_id
            $table->string('telegram_username');
            $table->string('chat_url');
            // $table->string('chat_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            // Создаем внешний ключ, который ссылается на таблицу users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_groups');
    }
};
