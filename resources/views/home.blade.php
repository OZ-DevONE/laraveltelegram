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
            <label for="chatUrl" class="form-label">Ссылка на чат/группу</label>
            <input type="url" class="form-control" id="chatUrl" name="chat_url" required>
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
</main>
@endsection
