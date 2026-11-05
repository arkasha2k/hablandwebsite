{{-- 🆕 Ресурс для админки: кнопка-ссылка в стиле проекта --}}
@props(['active' => false])

<a {{ $attributes->merge(['class' => 'btn-nav no-underline ' . ($active ? 'is-active' : '')]) }}>
    {{ $slot }}
</a>
