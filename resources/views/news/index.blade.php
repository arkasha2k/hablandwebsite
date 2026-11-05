{{-- 🆕 НОВЫЙ ФАЙЛ: resources/views/news/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Новости — Habland Hotel')

@section('content')
<section class="fade-up pt-6 md:pt-10 pb-4">
    <h1 class="h1">Новости <span class="grad-text">отеля</span></h1>
    <p class="lead mt-3 max-w-xl">Свежие события, обновления каталога и конкурсы. Заселяйтесь в курс событий! <span class="blink">_</span></p>
</section>

@if($news->count() === 0)
    {{-- Пустое состояние --}}
    <div class="card p-10 text-center mt-6">
        <div class="text-5xl mb-4 floaty inline-block">📰</div>
        <h2 class="h3 mb-2">Пока тихо…</h2>
        <p class="small text-mute">Новостей ещё нет — загляните позже или вернитесь <a href="{{ route('home') }}" class="text-violet-300 font-bold">на главную</a>.</p>
    </div>
@else
    {{-- Закреплённая (featured) новость --}}
    @php $first = $news->first(); @endphp
    @if($first->featured && $news->currentPage() === 1)
        <section class="reveal mt-6">
            <x-news-card :item="$first" :featured="true" />
        </section>
    @endif

    {{-- Лента --}}
    <section class="reveal mt-6">
        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($news as $n)
                @continue($first->featured && $loop->first && $news->currentPage() === 1)
                <x-news-card :item="$n" />
            @endforeach
        </div>
    </section>

    <div class="mt-9">{{ $news->links() }}</div>
@endif
@endsection
