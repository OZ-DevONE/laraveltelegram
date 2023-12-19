@extends('layaouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
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

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
