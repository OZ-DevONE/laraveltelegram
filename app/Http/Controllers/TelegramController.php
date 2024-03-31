<?php 
namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use App\Models\UserSetting;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhook()
    {
        try {
            $update = Telegram::commandsHandler(true);

            $newMember = $update->getMessage()->getNewChatMembers();
            if ($newMember) {
                $this->handleNewChatMembers($newMember, $update);
            }

            $message = $update->getMessage();
            if ($message && $message->getText()) {
                $this->handleMessage($message);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function handleNewChatMembers($newMembers, $update)
    {
        $botId = config('services.telegram.bot_id');
        foreach ($newMembers as $member) {
            if ($member->getId() == $botId) {
                $chatId = $update->getMessage()->getChat()->getId();
                $chat = TelegramGroup::where('chat_id', $chatId)->first();
                
                if ($chat) {
                    $chat->update(['is_active' => true]);
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Бот подключен и готов к работе!'
                    ]);
                } else {
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Бот не может работать в этом чате.'
                    ]);
                    Telegram::leaveChat(['chat_id' => $chatId]);
                }
            }
        }
    }

    private function handleMessage($message)
    {
        $chatId = $message->getChat()->getId();
        $text = $message->getText();
    
        // Получаем настройки для чата
        $chatSettings = UserSetting::where('chat_id', $chatId)->first();
    
        // Проверяем, включена ли функция антимата для чата
        if ($chatSettings && $chatSettings->is_feature_active) {
            if ($this->containsBadWords($text, $chatSettings->bad_words_list)) {
                $this->deleteMessageAndWarnUser($chatId, $message);
            }
        }
    
        if ($this->containsLink($text)) {
            $this->deleteMessageWithLink($chatId, $message);
        }
    }
    

    private function deleteMessageAndWarnUser($chatId, $message)
    {
        Telegram::deleteMessage([
            'chat_id' => $chatId,
            'message_id' => $message->getMessageId()
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Неприемлемый язык удален.'
        ]);
    }

    private function deleteMessageWithLink($chatId, $message)
    {
        Telegram::deleteMessage([
            'chat_id' => $chatId,
            'message_id' => $message->getMessageId()
        ]);

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Ссылка в сообщении была удалена.'
        ]);
    }
    
    private function containsBadWords($text, $badWordsList)
    {
        foreach ($badWordsList as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }
    
    
    private function containsLink($text)
    {
        $regex = "/https?:\/\/[a-z0-9-]+(\.[a-z]{2,})+[^ \n]*/i";
        return preg_match($regex, $text);
    }
}
