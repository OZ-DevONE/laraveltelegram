<?php 
namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    protected $activityLog = [];

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

        if ($message) {
            $chatId = $message->getChat()->getId();
            $userId = $message->getFrom()->getId();
            $text = $message->getText();
            $isSticker = $message->getSticker() ? true : false;
            $containsLink = $this->containsLink($text);

            $this->updateUserActivity($userId, $chatId, $isSticker, $containsLink);

            if ($this->isUserOverActive($userId, $chatId)) {
                $this->deleteRecentMessages($userId, $chatId);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function containsBadWords($text)
    {
        $badWords = ['блять', 'сука', 'хуйло', 'типа матное слово', 'хуй', 'пидорас', 'пидор', 'хуеглот', ''];
        foreach ($badWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    private function containsLink($text)
    {
        return preg_match('/\bhttps?:\/\/\S+/i', $text);
    }

    private function updateUserActivity($userId, $chatId, $isSticker, $containsLink)
    {
        $currentTime = time();

        // Очищаем устаревшие записи
        foreach ($this->activityLog as $key => $log) {
            if ($currentTime - $log['time'] > 300) { // 300 секунд = 5 минут
                unset($this->activityLog[$key]);
            }
        }

        // Добавляем новую запись
        $this->activityLog[] = [
            'userId' => $userId,
            'chatId' => $chatId,
            'isSticker' => $isSticker,
            'containsLink' => $containsLink,
            'time' => $currentTime
        ];
    }

    private function isUserOverActive($userId, $chatId)
    {
        $countMessages = 0;
        $countStickers = 0;
        $countLinkMessages = 0;

        foreach ($this->activityLog as $log) {
            if ($log['userId'] == $userId && $log['chatId'] == $chatId) {
                $countMessages++;
                if ($log['isSticker']) {
                    $countStickers++;
                }
                if ($log['containsLink']) {
                    $countLinkMessages++;
                }
            }
        }

        // Условия для определения подозрительной активности
        return $countMessages > 10 || $countStickers > 5 || $countLinkMessages > 3;
    }

    private function deleteRecentMessages($userId, $chatId)
    {
        foreach ($this->activityLog as $log) {
            if ($log['userId'] == $userId && $log['chatId'] == $chatId) {
                Telegram::deleteMessage([
                    'chat_id' => $chatId,
                    'message_id' => $log['messageId']
                ]);
            }
        }
    }
    
}
