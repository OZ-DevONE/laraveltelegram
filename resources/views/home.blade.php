@extends('layaouts.app')

@section('content')
<main class="container">
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
