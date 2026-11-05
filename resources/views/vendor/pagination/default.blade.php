{{-- Тема пагинации в стиле Habland Hotel (токены из DESIGN-GUIDE.md) --}}
@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2 flex-wrap" aria-label="Навигация по страницам">
        {{-- Предыдущая --}}
        @if ($paginator->onFirstPage())
            <span class="px-3.5 py-2 rounded-lg border border-line text-mute/40 font-display text-[10px] font-bold select-none" aria-hidden="true">← НАЗАД</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-3.5 py-2 rounded-lg border border-line font-display text-[10px] font-bold hover:border-violet-500 hover:text-white transition"
               aria-label="Предыдущая страница">← НАЗАД</a>
        @endif

        {{-- Страницы --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-mute font-bold select-none" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="px-3.5 py-2 rounded-lg bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white font-display text-[10px] font-bold shadow-[0_3px_0_#4C1D95] select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Страница {{ $page }}"
                           class="px-3.5 py-2 rounded-lg border border-line font-display text-[10px] font-bold text-mute hover:border-violet-500 hover:text-white transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Следующая --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-3.5 py-2 rounded-lg border border-line font-display text-[10px] font-bold hover:border-violet-500 hover:text-white transition"
               aria-label="Следующая страница">ВПЕРЕД →</a>
        @else
            <span class="px-3.5 py-2 rounded-lg border border-line text-mute/40 font-display text-[10px] font-bold select-none" aria-hidden="true">ВПЕРЕД →</span>
        @endif
    </nav>
@endif
