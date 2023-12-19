<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelegramGroup;

class ChatController extends Controller
{
    public function edit($id)
    {
        $chat = TelegramGroup::findOrFail($id);
        return view('edit', compact('chat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'telegram_username' => 'required|max:255',
            'chat_id' => 'required|max:255',
        ]);

        $chat = TelegramGroup::findOrFail($id);
        $chat->update($request->all());

        return redirect()->route('user.home')->with('status', 'Чат обновлен');
    }

    public function destroy($id)
    {
        $chat = TelegramGroup::findOrFail($id);
        $chat->delete();

        return redirect()->route('user.home')->with('status', 'Чат удален');
    }

}
