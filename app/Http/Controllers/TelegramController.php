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

        // Проверяем, есть ли информация о новом участнике чата
        $newMember = $update->getMessage()->getNewChatMembers();
        $botId = config('services.telegram.bot_id');
        if ($newMember) {
            foreach ($newMember as $member) {
                // Проверяем, является ли новый участник нашим ботом
                if ($member->getId() == $botId) {
                    // Отправляем сообщение в чат
                    Telegram::sendMessage([
                        'chat_id' => $update->getMessage()->getChat()->getId(),
                        'text' => 'Подключен'
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function checkBotAdminStatus()
    {
        $telegramGroups = TelegramGroup::where('is_active', true)->get();

        foreach ($telegramGroups as $group) {
            // Получаем информацию о члене группы (боте)
            $response = Telegram::getChatMember([
                'chat_id' => $group->chat_url,
                'user_id' => env('TELEGRAM_BOT_ID'),
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
