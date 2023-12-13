<?php

namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Illuminate\Http\Request;

class TelegramGroupController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'telegram_username' => 'required',
            'chat_id' => 'required'
        ]);
        
        $telegramGroup = new TelegramGroup();
        $telegramGroup->user_id = auth()->id();
        $telegramGroup->telegram_username = $request->telegram_username;
        $telegramGroup->chat_id = $request->chat_id;
        $telegramGroup->save();
        
        return redirect()->back()->with('status', 'Данные добавлены.');
        
    }
}
