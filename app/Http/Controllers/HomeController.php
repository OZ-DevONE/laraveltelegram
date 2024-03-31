<?php

namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        $userId = auth()->user()->id; // Получение ID текущего пользователя из auth
    
        // Получение активных и неактивных чатов пользователя с пагинацией
        $activeChats = TelegramGroup::where('user_id', $userId)
                                    ->where('is_active', true)
                                    ->paginate(5); 
        
        $inactiveChats = TelegramGroup::where('user_id', $userId)
                                      ->where('is_active', false)
                                      ->paginate(5);
    
        // Получение настроек пользователя для каждого активного чата
        $userSettings = UserSetting::where('user_id', $userId)->get()->keyBy('chat_id');
    
        // Возврат в представление home со списком активных и неактивных чатов, а также настройками пользователя
        return view('home', [
            'activeChats' => $activeChats, 
            'inactiveChats' => $inactiveChats,
            'userSettings' => $userSettings
        ]);
    }
    
    
    // Рассылка сообщений 
    public function sendToAllChats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'image' => 'nullable|url|regex:/\.(jpeg|jpg|png|gif|mp4)$/i',
            'chat_id' => 'required|exists:telegram_groups,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $text = $request->input('text');
        $imageUrl = $request->input('image');
        $chatId = $request->input('chat_id');

        // Отправка сообщения в выбранный чат
        $this->sendMessageToChat($chatId, $text, $imageUrl);

        return redirect()->back()->with('status', 'Сообщение отправлено в выбранный чат.');
    }

    protected function sendMessageToChat($chatId, $text, $imageUrl)
    {
        if ($imageUrl) {
            $extension = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    Telegram::sendPhoto([
                        'chat_id' => $chatId,
                        'photo' => InputFile::create($imageUrl, basename($imageUrl)),
                        'caption' => $text
                    ]);
                    break;
                case 'gif':
                    Telegram::sendAnimation([
                        'chat_id' => $chatId,
                        'animation' => InputFile::create($imageUrl, basename($imageUrl)),
                        'caption' => $text
                    ]);
                    break;
                case 'mp4':
                    Telegram::sendVideo([
                        'chat_id' => $chatId,
                        'video' => InputFile::create($imageUrl, basename($imageUrl)),
                        'caption' => $text
                    ]);
                    break;
            }
        } else {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text
            ]);
        }
    }

    public function updateUserSettings(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:telegram_groups,id',
            'bad_words_list' => 'nullable|string',
            'is_feature_active' => 'nullable|boolean'
        ]);
    
        $userId = auth()->user()->id;
        $chatId = $request->input('chat_id');
        $badWordsList = $request->input('bad_words_list') ? explode(' ', $request->input('bad_words_list')) : []; // Преобразуем строку в массив, разделяя слова по пробелу
        $isFeatureActive = $request->has('is_feature_active');
    
        // Находим или создаем запись в модели UserSetting для данного пользователя и чата
        $userSetting = UserSetting::updateOrCreate(
            [
                'user_id' => $userId,
                'chat_id' => $chatId
            ],
            [
                'bad_words_list' => $badWordsList,
                'is_feature_active' => $isFeatureActive
            ]
        );
    
        return redirect()->back()->with('success', 'Настройки чата обновлены.');
    }
    
    
}
