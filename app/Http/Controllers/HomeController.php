<?php

namespace App\Http\Controllers;

use App\Models\TelegramGroup;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $activeChats = TelegramGroup::where('is_active', true)->get();
        $inactiveChats = TelegramGroup::where('is_active', false)->get();
    
        return view('home', ['activeChats' => $activeChats, 'inactiveChats' => $inactiveChats]);
    }
    
}
