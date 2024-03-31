<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramGroup extends Model
{
    use HasFactory;

    // Добавляем свойство для ID чата
    protected $fillable = ['user_id', 'telegram_username', 'chat_id', 'is_active'];
}
