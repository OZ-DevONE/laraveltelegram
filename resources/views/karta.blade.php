<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта сайта - N [ i ] p l</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Карта сайта</h2>
        <ul class="list-unstyled">
            <li><a href="/" class="text-decoration-none">Главная</a></li>
            <li><a href="{{ route('user.home') }}" class="text-decoration-none">Личный кабинет пользователя</a></li>
            <li><a href="{{ route('user.login') }}" class="text-decoration-none">Войти в Личный кабинет.</a></li>
            <li><a href="{{ route('user.register') }}" class="text-decoration-none">Страница регистрации</a></li>
            <li><a href="{{ url('/about') }}" class="text-decoration-none">Страница О нас</a></li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
