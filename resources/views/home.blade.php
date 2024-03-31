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
        <h2>Добавление Telegram группы</h2>
        <form method="POST" action="{{ route('telegram.add') }}">
            @csrf
            <div class="mb-3">
                <label for="telegramUsername" class="form-label">Ник в Telegram</label>
                <input type="text" class="form-control" id="telegramUsername" name="telegram_username" required>
            </div>
            <div class="mb-3">
                <label for="chatId" class="form-label">ID группы</label>
                <input type="text" class="form-control" id="chatId" name="chat_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>

        <h2>Активные чаты</h2>
        {{-- Перебери весь массив переданных данных --}}
        @foreach ($activeChats as $chat)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $chat->telegram_username }}</h5>
                    <p class="card-text">{{ $chat->chat_id }}</p>
        
                    <!-- Кнопка для открытия модального окна с настройками для конкретного чата -->
                    <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#chatSettingsModal-{{ $chat->id }}">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
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

@foreach ($activeChats as $chat)
    <!-- Модальное окно с настройками для конкретного чата -->
    <div class="modal fade text-dark" id="chatSettingsModal-{{ $chat->id }}" tabindex="-1" role="dialog" aria-labelledby="chatSettingsModalLabel-{{ $chat->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatSettingsModalLabel-{{ $chat->id }}">Настройки чата: {{ $chat->telegram_username }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Форма отправки сообщения в чат -->
                    <h4>Отправить сообщение</h4>
                    <form action="{{ route('send-to-all-chats') }}" method="POST">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <div class="form-group">
                            <label for="text-{{ $chat->id }}">Текст:</label>
                            <textarea class="form-control" id="text-{{ $chat->id }}" name="text" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image-{{ $chat->id }}">Ссылка на изображение:</label>
                            <input class="form-control" type="url" id="image-{{ $chat->id }}" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>

                    <!-- Форма настройки антимата для чата -->
                    <h4>Настройки антимата</h4>
                    <form action="{{ route('user.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <div class="form-group">
                            <label for="badWordsList-{{ $chat->id }}">Список слов для фильтрации:</label>
                            <textarea class="form-control" id="badWordsList-{{ $chat->id }}" name="bad_words_list" rows="3"
                                      placeholder="Данных нету">{{ isset($userSettings[$chat->id]) ? implode(' ', $userSettings[$chat->id]->bad_words_list) : '' }}</textarea>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="isFeatureActive-{{ $chat->id }}" name="is_feature_active"
                                   {{ isset($userSettings[$chat->id]) && $userSettings[$chat->id]->is_feature_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFeatureActive-{{ $chat->id }}">Включить антимат</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить настройки</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

  
@endsection
