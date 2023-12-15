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
            'is_active' => 'required|boolean'
        ]);

        $chat = TelegramGroup::findOrFail($id);
        $chat->update($request->all());

        return redirect()->route('home')->with('status', 'Чат обновлен');
    }

    public function destroy($id)
    {
        $chat = TelegramGroup::findOrFail($id);
        $chat->delete();

        return redirect()->route('home')->with('status', 'Чат удален');
    }

}
