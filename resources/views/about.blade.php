{{-- Файл resources/views/about.blade.php --}}

@extends('layaouts.app')

@section('head')
    {{-- Ваши стили или ссылки на стили --}}
@endsection

@section('content')
    <div class="container my-5">
        <h1 class="text-center">О нас</h1>
        <p class="text-justify">
            Добро пожаловать на страницу "О нас"! Здесь вы можете узнать больше о нашей компании, миссии, истории и людях, которые делают нашу компанию уникальной. Мы гордимся тем, что предоставляем качественные услуги нашим клиентам уже более десяти лет.
        </p>
        
        {{-- Вставьте здесь более подробную информацию о вашей компании --}}
        
        <section id="team">
            <h2 class="text-center">Наша команда</h2>
            <p>Наши сотрудники - это сердце нашего бизнеса. Ознакомьтесь с профессионалами, которые вносят свой вклад в наш успех каждый день.</p>
            
            {{-- Пример списка сотрудников или команды --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://gas-kvas.com/grafic/uploads/posts/2023-09/1695835364_gas-kvas-com-p-kartinki-kapibara-1.jpg" alt="Имя Сотрудника" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Капибара 1</h5>
                            <p class="card-text">Какиш</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Пример списка сотрудников или команды --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://petstime.ru/wp-content/uploads/2023/04/word-image-13637-8.jpeg" alt="Имя Сотрудника" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Капибара 2</h5>
                            <p class="card-text">Какиш</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Пример списка сотрудников или команды --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://petstime.ru/wp-content/uploads/2023/04/word-image-13637-5.jpeg" alt="Имя Сотрудника" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Капибара 3</h5>
                            <p class="card-text">Какиш</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        
        <section id="values">
            <h2 class="text-center">Наши ценности</h2>
            <p>Мы стремимся к созданию доверительных отношений с нашими клиентами и партнерами. Наши ключевые ценности включают честность, прозрачность и стремление к инновациям.</p>
        </section>
        
        <section id="history">
            <h2 class="text-center">Наша история</h2>
            <p>С момента основания в 2010 году, наша компания постоянно росла и развивалась. От маленькой стартап-команды до ведущего игрока на рынке.</p>
        </section>
    </div>
@endsection

