<?php

namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\FileUpload\InputFile;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        $userId = auth()->user()->id; // Получение ID текущего пользователя из auth
    
        $activeChats = TelegramGroup::where('user_id', $userId)
                                    ->where('is_active', true)
                                    ->paginate(5); 
        
        $inactiveChats = TelegramGroup::where('user_id', $userId)
                                      ->where('is_active', false)
                                      ->paginate(5);
    
        return view('home', ['activeChats' => $activeChats, 'inactiveChats' => $inactiveChats]);
    }
    
    

    public function sendToAllChats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => [
                'required', 
                'string', 
                'max:255'
            ],
            'image' => [
                'nullable', 
                'url', 
                'regex:/\.(jpeg|jpg|png|gif|mp4)$/i'
            ], 
        ]);        
    
        // Проверка на ошибки валидации
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $text = $request->input('text'); // text Текст
        $imageUrl = $request->input('image'); // URL изображения

        $userId = auth()->user()->id; // Получение ID текущего пользователя из auth
        $activeChats = TelegramGroup::where('user_id', $userId)
                                    ->where('is_active', true)
                                    ->get();

        foreach ($activeChats as $chat) {    
            //Есть ссылка?    
            if ($imageUrl) {
                $extension = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        // Отправка изображения с подписью
                        $image = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendPhoto([
                            'chat_id' => $chat->chat_id, // его чат id
                            'photo' => $image, // Тут фото
                            'caption' => $text // Тут текст
                        ]);
                        break;
                    case 'gif':
                        // Отправка GIF с подписью
                        $gif = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendAnimation([
                            'chat_id' => $chat->chat_id, // его чат id
                            'animation' => $gif, // Тут гиф
                            'caption' => $text // Тут текст
                        ]);
                        break;
                    case 'mp4':
                        // Отправка видео с подписью
                        $video = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendVideo([
                            'chat_id' => $chat->chat_id, // его чат id
                            'video' => $video, // Тут видео
                            'caption' => $text // Тут текст
                        ]);
                        break;
                }
            } else {
                // Отправка только текстового сообщения, если нет изображения а именно нету ссылки
                Telegram::sendMessage([
                    'chat_id' => $chat->chat_id,
                    'text' => $text
                ]);
            }
        }         

        return redirect()->back()->with('status', 'Сообщение отправлено во все активные чаты');
    }
    
}
