<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $update = Telegram::commandsHandler(true);

        // Получаем текст сообщения
        $text = $update->getMessage()->getText();

        // Получаем ID чата
        $chat_id = $update->getMessage()->getChat()->getId();

        // Отправляем ответное сообщение
        Telegram::sendMessage([
            'chat_id' => $chat_id, 
            'text' => 'Вы отправили: ' . $text
        ]);

        return response()->json(['status' => 'success']);
    }
}
