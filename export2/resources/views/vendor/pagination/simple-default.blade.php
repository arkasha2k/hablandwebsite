{{-- Простая тема пагинации (->simplePaginate) в стиле Habland Hotel --}}
@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-3" role="navigation" aria-label="Навигация по страницам">
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 rounded-lg border border-line text-mute/40 font-display text-[10px] font-bold select-none" aria-hidden="true">← НАЗАД</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-4 py-2 rounded-lg border border-line font-display text-[10px] font-bold hover:border-violet-500 hover:text-white transition"
               aria-label="Предыдущая страница">← НАЗАД</a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-4 py-2 rounded-lg border border-line font-display text-[10px] font-bold hover:border-violet-500 hover:text-white transition"
               aria-label="Следующая страница">ВПЕРЕД →</a>
        @else
            <span class="px-4 py-2 rounded-lg border border-line text-mute/40 font-display text-[10px] font-bold select-none" aria-hidden="true">ВПЕРЕД →</span>
        @endif
    </nav>
@endif
