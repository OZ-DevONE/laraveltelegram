@extends('layaouts.app')

@section('content')
<main class="form-signin">
    <form method="POST" action="{{ route('auth.loginin-user') }}">
      @csrf
      <h1 class="h3 mb-3 fw-normal">Пожалуйста, войдите</h1>

      <div class="form-floating mb-3">
        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required>
        <label for="floatingInput">Email адрес</label>
        @if ($errors->has('email'))
            <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div>
        @endif
      </div>
      <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="floatingPassword" placeholder="Пароль" required>
        <label for="floatingPassword">Пароль</label>
        @if ($errors->has('password'))
            <div class="invalid-feedback">
                {{ $errors->first('password') }}
            </div>
        @endif
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
      <p>Нет аккаунта? <a href="{{ route('user.register') }}">Создать</a>.</p>
    </form>
</main>
@endsection
