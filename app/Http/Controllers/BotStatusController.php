<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram\Bot\Api;

class BotStatusController extends Controller
{
    public function index()
    {
        try {
            $telegram = new Api(config('services.telegram.bot_token')); //Инициализирум бота перет из сервиса а там лежит токен взятый из .env
            $response = $telegram->getMe(); //как написано в доках симпел тест на то что бот прошел аунтификацию
            $botName = $response->getUsername(); //из $response дай мне имя бота
            $connected = true; // пишем для того чтобы знать что все успешно
        } catch (\Exception $e) { //все плохо
            $botName = null; //имя нету
            $connected = false; //нету коннекта
        }

        return view('bot_status', compact('botName', 'connected')); //верни мне вью с данными ваше
    }
}

