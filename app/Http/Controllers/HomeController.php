<?php

namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class HomeController extends Controller
{
    // public function home()
    // {
    //     $activeChats = TelegramGroup::where('is_active', true)->get();
    //     $inactiveChats = TelegramGroup::where('is_active', false)->get();
    
    //     return view('home', ['activeChats' => $activeChats, 'inactiveChats' => $inactiveChats]);
    // }

    public function sendToAllChats(Request $request)
    {
        $text = $request->input('text');
        $image = $request->input('image'); // предполагается, что это URL изображения

        $activeChats = TelegramGroup::where('is_active', true)->get();

        foreach ($activeChats as $chat) {
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => $text
            ]);

            if ($image) {
                Telegram::sendPhoto([
                    'chat_id' => $chat->chat_id,
                    'photo' => $image
                ]);
            }
        }

        return redirect()->back()->with('status', 'Сообщение отправлено во все активные чаты');
    }
    
}
