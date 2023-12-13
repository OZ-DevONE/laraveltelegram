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
            'chat_url' => 'required|url'
        ]);

        $telegramGroup = new TelegramGroup();
        $telegramGroup->user_id = auth()->id();
        $telegramGroup->telegram_username = $request->telegram_username;
        $telegramGroup->chat_url = $request->chat_url;
        $telegramGroup->save();

        return redirect()->back()->with('status', 'Данные добавлены.');
    }
}
