@extends('layaouts.app')

@section('head')
    <style>
        html {
        scroll-behavior: smooth;
        }
        body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        }

        .card {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: box-shadow 0.3s ease-in-out;
        }

        .card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        }

        .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        }

        /* Медиа-запросы для отзывчивого дизайна */
        @media (max-width: 768px) {
        .card-body {
            padding: 15px;
        }
        }
    </style>
@endsection 


@section('content')
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
    @foreach ($activeChats as $chat)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                <p class="card-text">{{ $chat->chat_id }}</p>
                <a href="{{ route('chats.edit', $chat->id) }}" class="btn btn-primary">Редактировать</a>
                <form action="{{ route('chats.destroy', $chat->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    @endforeach
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
    {{ $inactiveChats->links() }}
</div>
@endsection
