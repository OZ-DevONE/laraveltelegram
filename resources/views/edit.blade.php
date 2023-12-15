@extends('layaouts.app')

@section('content')
    <form action="{{ route('chats.update', $chat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="telegramUsername" class="form-label">Ник в Telegram</label>
            <input type="text" class="form-control" id="telegramUsername" name="telegram_username" value="{{ $chat->telegram_username }}" required>
        </div>

        <div class="mb-3">
            <label for="chatId" class="form-label">ID чата/группы</label>
            <input type="text" class="form-control" id="chatId" name="chat_id" value="{{ $chat->chat_id }}" required>
        </div>

        <div class="mb-3">
            <label for="isActive" class="form-label">Активен</label>
            <select class="form-control" id="isActive" name="is_active">
                <option value="1" {{ $chat->is_active ? 'selected' : '' }}>Да</option>
                <option value="0" {{ !$chat->is_active ? 'selected' : '' }}>Нет</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>
@endsection
