{{-- Файл resources/views/about.blade.php --}}

@extends('layaouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('/css/cover.css') }}"> 
<link rel="stylesheet" href="{{asset('/css/video.css')}}">
@endsection

@section('content')
<body class="d-flex text-center text-white">
    <div class="cover-container d-flex p-3 mx-auto flex-column">
        <div class="video-container">
            <video autoplay muted loop id="myVideo" class="embed-responsive-item">
                <source src="https://static.vecteezy.com/system/resources/previews/006/405/981/mp4/cyber-security-of-digital-data-network-protection-binary-code-and-padlock-connectivity-background-concept-free-video.mp4" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
        </div>  
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
        <br>
        <h1 class="text-center">О нас</h1>
            <p class="text-justify">
                Наша компания, основанная в 2010 году, была создана с целью преобразования индустрии администрирования телеграмм каналов. С первых дней своего существования мы стремились к инновациям и качеству во всем, что мы делаем. Наша миссия - обеспечить клиентов не только высококачественными услугами, но и инструментами для достижения их бизнес-целей.
            </p>
    

            <h2 class="text-center">Наша команда</h2>
            <p>Наши сотрудники - это ключ к успеху нашего бизнеса. Каждый член команды приносит уникальный набор навыков и опыт, создавая основу для нашего совместного успеха. Вместе мы стремимся к постоянному самосовершенствованию и развитию нашей компании.</p>

        
            <h2 class="text-center">Наши ценности</h2>
            <p>Прозрачность, доверие и инновации являются основополагающими камнями нашей корпоративной культуры. Мы верим, что честный и открытый диалог с нашими клиентами и партнерами является ключом к долгосрочным отношениям.</p>
        
            <h2 class="text-center">Наша история</h2>
            <p>За годы нашей работы мы превратились из небольшого стартапа в ведущего игрока на рынке администрирования телеграмм каналов. Каждый этап нашего развития был наполнен как вызовами, так и достижениями, и мы гордимся тем, как мы смогли их преодолеть и продолжать двигаться вперед.</p>

    </div>
</body>
@endsection