@extends('layouts.app')

@section('title', 'Вход — Habland Hotel')

@section('content')
<div class="max-w-md mx-auto fade-up">
    <div class="card p-6 md:p-9">
        <div class="text-center mb-8">
            <span class="inline-block text-4xl mb-4" aria-hidden="true">🔑</span>
            <h1 class="h2">С возвращением</h1>
            <p class="small text-mute mt-2">Отель ждал именно тебя</p>
        </div>

        @if($errors->any())
            <div class="rounded-xl border border-rose-400/40 bg-rose-500/10 px-4 py-3 mb-5 small text-rose-300 space-y-1">
                @foreach($errors->all() as $e) <div>✖ {{ $e }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="username" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Никнейм</label>
                <input id="username" name="username" value="{{ old('username') }}" class="field" placeholder="Твой ник в отеле" required autofocus autocomplete="username">
            </div>
            <div>
                <label for="password" class="block small font-extrabold uppercase tracking-wider text-mute mb-2">Пароль</label>
                <input id="password" type="password" name="password" class="field" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <label class="flex items-center gap-2.5 small text-mute cursor-pointer select-none">
                <input type="checkbox" name="remember" value="1" class="w-4 h-4 rounded accent-violet-500">
                Запомнить меня
            </label>
            <button class="btn w-full">▶ ВОЙТИ В ОТЕЛЬ</button>
        </form>

        <p class="text-center small text-mute mt-7">
            Нет аккаунта?
            <a href="{{ route('register') }}" class="font-bold text-violet-300 hover:text-fuchsia-300 transition">Создать за минуту</a>
        </p>
    </div>
</div>
@endsection
