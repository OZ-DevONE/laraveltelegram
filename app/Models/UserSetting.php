<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'chat_id', 'bad_words_list', 'is_feature_active'
    ];

    protected $casts = [
        'bad_words_list' => 'array',
        'is_feature_active' => 'boolean',
    ];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Добавляем связь с моделью TelegramGroup
    public function telegramGroup()
    {
        return $this->belongsTo(TelegramGroup::class, 'chat_id');
    }
}
