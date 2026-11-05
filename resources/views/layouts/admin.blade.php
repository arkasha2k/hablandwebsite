{{-- 🆕 ХЕДЕР АДМИНКИ: расширяем основной layout и добавляем навигацию персонала --}}
@extends('layouts.app')

@section('content')
    <nav class="card flex flex-wrap gap-2 p-3 mb-6" aria-label="Админ-навигация">
        <a href="{{ route('admin.home') }}" class="btn-nav no-underline {{ request()->routeIs('admin.home') ? 'is-active' : '' }}">📊 Дашборд</a>
        <a href="{{ route('admin.news.index') }}" class="btn-nav no-underline {{ request()->routeIs('admin.news.*') ? 'is-active' : '' }}">📰 Новости</a>
        <a href="{{ route('admin.users.index') }}" class="btn-nav no-underline {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">👥 Игроки</a>
        <a href="{{ route('admin.logs') }}" class="btn-nav no-underline {{ request()->routeIs('admin.logs') ? 'is-active' : '' }}">🧾 Логи</a>
        <span class="flex-1"></span>
        <span class="btn-nav !pointer-events-none opacity-70">🛡 {{ auth()->user()->username }} · {{ auth()->user()->rank_name }}</span>
    </nav>

    @yield('admin-content')
@endsection
