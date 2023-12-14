@extends('layaouts.app')

@section('content')
<main class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
        <button type="submit" class="btn btn-primary">Отправить во все чаты</button>
    </form>

    <h2>Активные чаты</h2>
    @foreach ($activeChats as $chat)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                <p class="card-text">{{ $chat->chat_id }}</p>
            </div>
        </div>
    @endforeach

    <h2>Неактивные чаты</h2>
    @foreach ($inactiveChats as $chat)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                <p class="card-text">{{ $chat->chat_id }}</p>
            </div>
        </div>
    @endforeach
</main>
@endsection
