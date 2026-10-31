{{-- 🆕 НОВЫЙ ФАЙЛ: resources/views/components/news-card.blade.php --}}
@props(['item', 'featured' => false])

<a href="{{ route('news.show', $item->id) }}"
   class="card card-hover block p-5 md:p-6 no-underline text-inherit {{ $featured ? 'md:p-8' : '' }}">

    <div class="flex items-center gap-2.5 flex-wrap mb-3">
        {{-- Бейдж категории --}}
        @php
            $c = $item->category_color;
            $badge = match($c) {
                'cyan'    => 'text-cyan-300 bg-cyan-500/10 border-cyan-400/30',
                'emerald' => 'text-emerald-300 bg-emerald-500/10 border-emerald-400/30',
                default   => 'text-fuchsia-300 bg-fuchsia-500/10 border-fuchsia-400/30',
            };
        @endphp
        <span class="small font-bold uppercase tracking-wider border rounded-full px-2.5 py-0.5 {{ $badge }}">
            {{ $item->category_label }}
        </span>
        <time class="small text-mute" datetime="{{ $item->created_at_int?->toIso8601String() }}">
            {{ $item->created_at_int ? ($item->created_at_int->gt(now()->subDay())
                ? $item->created_at_int->diffForHumans(locale: 'ru', short: true)
                : $item->created_at_int->format('d.m.Y')) : '' }}
        </time>
    </div>

    <h3 class="h3 {{ $featured ? '!text-xl md:!text-2xl' : '' }} mb-2 group-hover:text-fuchsia-300 transition">
        @if($featured)<span aria-hidden="true">⭐ </span>@endif{{ $item->title }}
    </h3>

    <p class="small text-mute leading-relaxed {{ $featured ? 'line-clamp-4 !text-sm md:!text-base' : 'line-clamp-2' }}">
        {{ $item->body }}
    </p>

    <span class="inline-flex items-center gap-1 small font-bold text-violet-300 mt-3">Читать →</span>
</a>
