{{-- Файл resources/views/about.blade.php --}}

@extends('layaouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('/css/cover.css') }}"> 
<link rel="stylesheet" href="{{ asset('/css/signin.css') }}">
@endsection

@section('content')
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <main class="px-3 text-white">
        <h1 class="text-center">О нас</h1>
        <p class="lead">
            Наша компания занимается разработкой и внедрением передовых решений в области цифровой безопасности и управления данными. С момента нашего основания в 2010 году, мы постоянно стремимся к инновациям, чтобы предложить нашим клиентам лучшие в классе технологические решения. Наша миссия — обеспечивать надежную защиту информационных активов и поддерживать бизнес наших клиентов в условиях постоянно меняющегося цифрового ландшафта.
        </p>

        <section id="team" class="my-5">
            <h2 class="text-center">Наша команда</h2>
            <p class="lead">
                Мы гордимся нашей командой высококлассных специалистов, включая разработчиков, аналитиков, менеджеров по продукту и экспертов по кибербезопасности. Каждый из нас вносит неоценимый вклад в успех нашей компании, используя свой уникальный набор навыков и знаний для достижения общих целей.
            </p>
        </section>

        <section id="values" class="my-5">
            <h2 class="text-center">Наши ценности</h2>
            <p class="lead">
                Основой нашей работы являются ценности, которые вдохновляют нас на создание инноваций и развитие. Честность, прозрачность во взаимодействиях, стремление к постоянному обучению и совершенствованию, а также уважение к каждому сотруднику и клиенту — вот ключевые принципы, которыми мы руководствуемся в своей деятельности.
            </p>
        </section>

        <section id="history" class="my-5">
            <h2 class="text-center">Наша история</h2>
            <p class="lead">
                Начав свой путь в 2010 году как маленький стартап, мы выросли в крупную компанию, которая занимает лидирующие позиции в области цифровой безопасности. На протяжении всех этих лет мы оставались верны нашей миссии и ценностям, благодаря чему смогли добиться значительных успехов и заслужить доверие клиентов по всему миру.
            </p>
        </section>
    </main>

    <footer class="mt-auto text-white-50">
        <p>© Все права защищены - 2023</p>
    </footer>
</div>
@endsection