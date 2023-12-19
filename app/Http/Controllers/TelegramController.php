<?php 
namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        $update = Telegram::commandsHandler(true);

        // Проверяем, есть ли информация о новом участнике чата
        $newMember = $update->getMessage()->getNewChatMembers();
        $botId = config('services.telegram.bot_id');
        if ($newMember) {
            foreach ($newMember as $member) {
                // Проверяем, является ли новый участник нашим ботом
                if ($member->getId() == $botId) {
                    $chatId = $update->getMessage()->getChat()->getId();

                    $chat = TelegramGroup::where('chat_id', $chatId)->first();
                    
                    if ($chat) {
                        // Обновляем статус чата в базе данных
                        $chat->update(['is_active' => true]);
    
                        // Отправляем сообщение о подключении бота
                        Telegram::sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'Бот подключен и готов к работе!'
                        ]);
                    }else {
                        // Отправляем сообщение о том, что бот не будет работать в этом чате
                        Telegram::sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'Бот не может работать в этом чате или группе, так как он не зарегистрирован в системе.'
                        ]);
    
                        // Отправляем команду на выход бота из чата
                        Telegram::leaveChat([
                            'chat_id' => $chatId
                        ]);
                    }
                }
            }
        }

        $message = $update->getMessage();
        if ($message && $message->getText()) {
            $chatId = $message->getChat()->getId();
            $text = $message->getText();
    
            if ($this->containsBadWords($text)) {
                Telegram::deleteMessage([
                    'chat_id' => $chatId,
                    'message_id' => $message->getMessageId()
                ]);
    
                // Отправка предупреждения
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'В вашем сообщении обнаружен неприемлемый язык. Пожалуйста, соблюдайте правила чата.'
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function containsBadWords($text)
    {
        $badWords = ['блять', 'сука', 'хуйло', 'типа матное слово'];
        foreach ($badWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    // public function checkBotAdminStatus()
    // {
    //     $telegramGroups = TelegramGroup::all(); // Получаем все группы
    //     $botId = config('services.telegram.bot_id');
    //     foreach ($telegramGroups as $group) {
    //         // Получаем информацию о члене группы (боте)
    //         $response = Telegram::getChatMember([
    //             'chat_id' => $group->chat_id,
    //             'user_id' => $botId,
    //         ]);
    
    //         // Проверяем, является ли бот администратором
    //         if ($response->getStatus() === 'administrator') {
    //             $group->is_active = true;
    //         } else {
    //             $group->is_active = false;
    //         }
    //         $group->save();
    //     }
    //     // После обновления статусов, получаем актуальные данные
    //     $activeChats = TelegramGroup::where('is_active', true)->get();
    //     $inactiveChats = TelegramGroup::where('is_active', false)->get();

    //     // Передаем данные в представление
    //     return view('home', ['groups' => $telegramGroups, 'activeChats' => $activeChats, 'inactiveChats' => $inactiveChats]);
    // }
    
}
