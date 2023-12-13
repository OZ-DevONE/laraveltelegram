<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser extends Controller
{
    // Функция регистрации нового пользователя
    public function registerUser(Request $request){
        // Проверка на аунтификацию пользователя
        if(Auth::check()){
            return redirect(route('user.home'));
        }

        // Проверка всех данных которые были переданы
        $validFields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:filter|max:255|unique:users',
            'password' => 'required|min:8'
        ], [
            'name.required' => 'Имя обязательно к заполнению.',
            'name.max' => 'Имя не может быть длиннее 255 символов.',
            'email.required' => 'Адрес электронной почты обязателен к заполнению.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.max' => 'Адрес электронной почты не может быть длиннее 255 символов.',
            'email.unique' => 'Пользователь с таким адресом электронной почты уже существует.',
            'password.required' => 'Пароль обязателен к заполнению.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
        ]);        

        $user = User::create($validFields);
        if($user){
            Auth::login($user);
            return redirect(route('user.home'));
        }
    }

    // Функция входа для пользователя
    public function loginInUser(Request $request){
        // Проверка на аутентификацию пользователя
        if (Auth::check()) {
            return redirect(route('user.home'));
        }
    
        // Валидация введенных данных
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Необходимо ввести адрес электронной почты.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'password.required' => 'Необходимо ввести пароль.',
        ]);
    
        $formFields = $request->only(['email', 'password']);
    
        // Попытка аутентификации
        if (Auth::attempt($formFields)) {
            return redirect(route('user.home'));
        }
    
        // Возвращаемся обратно с сообщением об ошибке
        return back()->withErrors([
            'email' => 'Учетные данные не соответствуют нашим записям.',
        ]);
    }    
}
