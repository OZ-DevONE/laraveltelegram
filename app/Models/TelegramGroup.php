<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramGroup extends Model
{
    use HasFactory;
    
    // Защита от массового назначения
    protected $guarded = [];

    // Указываем имя таблицы, если оно не соответствует стандартному названию модели во множественном числе
    protected $table = 'telegram_groups';

    // Связь с моделью User (предполагая, что у вас есть такая модель)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
