<?php 
namespace App\Http\Controllers;

use App\Models\TelegramGroup;
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

    public function checkBotAdminStatus()
    {
        $telegramGroups = TelegramGroup::where('is_active', true)->get();

        foreach ($telegramGroups as $group) {
            // Получаем информацию о члене группы (боте)
            $response = Telegram::getChatMember([
                'chat_id' => $group->chat_url,
                'user_id' => env('TELEGRAM_BOT_ID'), // ID вашего бота
            ]);

            // Проверяем, является ли бот администратором
            if ($response->getStatus() === 'administrator') {
                $group->is_bot_admin = true;
            } else {
                $group->is_bot_admin = false;
            }

            $group->save();
        }

        return view('home', ['groups' => $telegramGroups]);
    }
}
