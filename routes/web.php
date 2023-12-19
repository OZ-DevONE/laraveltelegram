<?php

use App\Http\Controllers\AuthUser;
use App\Http\Controllers\BotStatusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TelegramGroupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bot-status', [BotStatusController::class, 'index']); // TEST STATUS

Route::post('/send-to-all-chats', [HomeController::class, 'sendToAllChats'])->name('send-to-all-chats')->middleware('auth');


//Группа пользователя
Route::name('user.')->group(function(){
    // Роутер отображения страницы юзера
    Route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');

    // Роутер пользователя, страница входа в личный кабинет.
    Route::get('/login', function(){
        if(Auth::check()){
            return redirect(route('user.home'));
        }
        return view('auth.login');
    })->name('login');

    // Роутер пользователя, страница регистрации для доступа к сайту.
    Route::get('/register', function(){
        if(Auth::check()){
            return redirect(route('user.home'));
        }
        return view('auth.register');
    })->name('register');
});

//Группа с конроллером аунтификации пользователя
Route::controller(AuthUser::class)->name('auth.')->group(function(){
    // Роутер post запроса на регистрацию пользователя
    Route::post('/register-user', 'registerUser')->name('register-user');

    // Роутер post запроса на авторизацию пользователя
    Route::post('/loginin-user', 'loginInUser')->name('loginin-user');

    // Роутер get запроса на logout пользователя
    Route::get('/logout', function(){
        Auth::logout();
        return redirect('/');
    })->name('logout');
});


//Добавление чата/группы
Route::post('/telegram-add', [TelegramGroupController::class, 'add'])->name('telegram.add');

Route::post('/telegram-webhook', [TelegramController::class, 'webhook']);

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/chats/{id}/edit', [ChatController::class, 'edit'])->name('chats.edit');
Route::put('/chats/{id}', [ChatController::class, 'update'])->name('chats.update');
Route::delete('/chats/{id}', [ChatController::class, 'destroy'])->name('chats.destroy');


Route::get('/sitemap', function () {
    return view('karta');
});