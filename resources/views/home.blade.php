@extends('layaouts.app')

@section('head')
<link rel="stylesheet" href="{{asset('/css/cover.css')}}"> 
@endsection

@section('content')
<body class="d-flex text-center text-white bg-dark">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="cover-container h-25 p-3 mx-auto flex-column">
            <header class="mb-auto">
                <div>
                    <h3 class="float-md-start mb-0"><a style="text-decoration: none; color:white;" href="/">N [ i ] p l</a> приветсвует тебя, {{ Auth::user()->name }}!</h3>
                    <nav class="nav nav-masthead justify-content-center float-md-end">
                    <a class="nav-link active" aria-current="page" href="logout">Выйти</a>
                    <a class="nav-link active" href="{{ url('/about') }}">О нас</a>
                    </nav>
                </div>
            </header>
        </div>
        <h2>Добавление Telegram чата/группы</h2>
        <form method="POST" action="{{ route('telegram.add') }}">
            @csrf
            <div class="mb-3">
                <label for="telegramUsername" class="form-label">Ник в Telegram</label>
                <input type="text" class="form-control" id="telegramUsername" name="telegram_username" required>
            </div>
            <div class="mb-3">
                <label for="chatId" class="form-label">ID чата/группы</label>
                <input type="text" class="form-control" id="chatId" name="chat_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
        
        <h2>Отправка поста в активные чаты</h2>
        <form action="{{ route('send-to-all-chats') }}" method="POST">
            @csrf
            <div>
                <label for="text">Текст:</label>
                <textarea class="form-control" id="text" name="text" required></textarea>
            </div>
            <div>
                <label for="image">Ссылка на изображение:</label>
                <input class="form-control" type="url" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>

        <h2>Активные чаты</h2>
        {{-- Перебери весь массив переданных данных --}}
        @foreach ($activeChats as $chat)
            <div class="card mb-3">
                <div class="card-body">
                    {{-- из данных достань нужные мне --}}
                    <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                    <p class="card-text">{{ $chat->chat_id }}</p>
                    {{-- вставь id чата в ссылку на редактирование --}}
                    <a href="{{ route('chats.edit', $chat->id) }}" class="btn btn-primary">Редактировать</a>
                    {{-- Форма удаление чата --}}
                    <form action="{{ route('chats.destroy', $chat->id) }}" method="POST" style="display:inline;">
                        @csrf
                        {{-- метод laravel удали элемент вместо get --}}
                        @method('DELETE') 
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
        {{-- пагинация на активные чаты --}}
        {{ $activeChats->links() }}
        
        <h2>Неактивные чаты</h2>
        @foreach ($inactiveChats as $chat)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                    <p class="card-text">{{ $chat->chat_id }}</p>
                    <p>Чтобы активировать, добавьте бота: <a href="https://t.me/laravelingormer_bot">laravelingormer_bot</a> в этот чат</p>
                    <a href="{{ route('chats.edit', $chat->id) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('chats.destroy', $chat->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach
        {{-- пагинация на не активные чаты --}}
        {{ $inactiveChats->links() }}
    </div>
</body>
@endsection
