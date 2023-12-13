@extends('layaouts.app')


@section('content')
</head>
<style>
    #myVideo {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%; 
        min-height: 100%;
    }

    .cover-container {
        position: relative;
        z-index: 1;
    }

    /* Стиль кнопки */
    .btn-interactive {
        transition: transform 0.2s, box-shadow 0.2s; /* Плавный переход для анимации */
    }

    /* Анимация при наведении */
    .btn-interactive:hover {
        transform: scale(1.05); /* Немного увеличиваем кнопку */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Добавляем тень для эффекта "поднятия" */
    }

    /* Анимация при нажатии */
    .btn-interactive:active {
        transform: scale(0.95); /* "Проваливаем" кнопку */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Уменьшаем тень */
    }
</style>
<body class="d-flex h-100 text-center text-white bg-dark">
    <video autoplay muted loop id="myVideo">
        <source src="https://static.vecteezy.com/system/resources/previews/006/405/981/mp4/cyber-security-of-digital-data-network-protection-binary-code-and-padlock-connectivity-background-concept-free-video.mp4" type="video/mp4">
    </video>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0"><a style="text-decoration: none; color:white;" href="/">N [ i ] p l</a></h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link active" aria-current="page" href="{{ route('user.home') }}">Главная</a>
            <a class="nav-link active" href="{{ route('user.login') }}">Войти</a>
            <a class="nav-link active" href="#">О-нас</a>
            </nav>
        </div>
        </header>

        <main class="px-3">
        <h1>Твой админ бот</h1>
        <p class="lead">Раскрой новые краски администрирования телеграмм каналов.</p>
        <p class="lead">
            <a href="{{ route('user.home') }}" class="btn btn-lg btn-secondary fw-bold border-white bg-white btn-interactive">
                Начать
            </a>
        </p>        
        </main>

        <footer class="mt-auto text-white-50">
            <p>©ALL rights reserved - 2023</p>
        </footer>
    </div>
</body>
@endsection