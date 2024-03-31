@extends('layaouts.app')

@section('head')
<link rel="stylesheet" href="{{asset('/css/cover.css')}}"> 
<link rel="stylesheet" href="{{asset('/css/signin.css')}}">
<link rel="stylesheet" href="{{asset('/css/video.css')}}">
@endsection

@section('content')
</head>

<body class="d-flex h-100 text-center text-white bg-dark">
    <div class="video-container">
        <video autoplay muted loop id="myVideo" class="embed-responsive-item">
            <source src="https://static.vecteezy.com/system/resources/previews/006/405/981/mp4/cyber-security-of-digital-data-network-protection-binary-code-and-padlock-connectivity-background-concept-free-video.mp4" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>    
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0"><a style="text-decoration: none; color:white;" href="/">N [ i ] p l</a></h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link active" aria-current="page" href="{{ route('user.home') }}">Главная</a>
            <a class="nav-link active" href="{{ route('user.login') }}">Войти</a>
            <a class="nav-link active" href="{{ url('/about') }}">О нас</a>
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