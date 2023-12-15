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
        $activeChats = TelegramGroup::where('is_active', true)->get();
        $inactiveChats = TelegramGroup::where('is_active', false)->get();
    
        return view('home', ['activeChats' => $activeChats, 'inactiveChats' => $inactiveChats]);
    }

    public function sendToAllChats(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\p{N}\p{P}\p{Zs}]+$/u'],
            'image' => ['required', 'url', 'regex:/\.(jpeg|jpg|png|gif|mp4)$/i'], 
        ]);
    
        // Проверка на ошибки валидации
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $text = $request->input('text');
        $imageUrl = $request->input('image'); // URL изображения

        $activeChats = TelegramGroup::where('is_active', true)->get();

        foreach ($activeChats as $chat) {
            // Отправка текстового сообщения
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => $text
            ]);
        
            if ($imageUrl) {
                // Определение типа медиа
                $extension = strtolower(pathinfo($imageUrl, PATHINFO_EXTENSION));
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        // Отправка изображения
                        $image = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendPhoto([
                            'chat_id' => $chat->chat_id,
                            'photo' => $image
                        ]);
                        break;
                    case 'gif':
                        // Отправка GIF
                        $gif = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendAnimation([
                            'chat_id' => $chat->chat_id,
                            'animation' => $gif
                        ]);
                        break;
                    case 'mp4':
                        // Отправка видео
                        $video = InputFile::create($imageUrl, basename($imageUrl));
                        Telegram::sendVideo([
                            'chat_id' => $chat->chat_id,
                            'video' => $video
                        ]);
                        break;
                }
            }
        }              

        return redirect()->back()->with('status', 'Сообщение отправлено во все активные чаты');
    }
    
}
