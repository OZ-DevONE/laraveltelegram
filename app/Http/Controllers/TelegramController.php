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
        $telegramGroups = TelegramGroup::all(); // Получаем все группы
        $botId = config('services.telegram.bot_id');
        foreach ($telegramGroups as $group) {
            // Получаем информацию о члене группы (боте)
            $response = Telegram::getChatMember([
                'chat_id' => $group->chat_id,
                'user_id' => $botId,
            ]);
    
            // Проверяем, является ли бот администратором
            if ($response->getStatus() === 'administrator') {
                $group->is_active = true;
            } else {
                $group->is_active = false;
            }
            $group->save();
        }
    
        return view('home', ['groups' => $telegramGroups]);
    }
    
}
