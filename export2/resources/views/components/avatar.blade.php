{{--
    Аватар-заглушка: стабильный «рандомный» эмодзи вместо внешнего Habbo-изображения.
    Параметры: $player (App\Models\User), $size ('sm'|'md'|'lg')
--}}
@php
    $classes = match($size ?? 'md') {
        'sm' => 'w-11 h-11 text-2xl rounded-xl',
        'lg' => 'w-28 h-28 text-6xl rounded-2xl',
        default => 'w-16 h-16 text-3xl rounded-xl',
    };
@endphp
<span
    {{ $attributes->merge(['class' => "inline-flex items-center justify-center select-none shrink-0 bg-gradient-to-b from-violet-500/25 to-transparent border border-line $classes"]) }}
    role="img"
    aria-label="Аватар {{ $player->username }}"
>{{ $player->emoji }}</span>
