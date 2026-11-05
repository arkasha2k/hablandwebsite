{{-- 🆕 /admin/news/create и /admin/news/{id}/edit — одна форма --}}
@extends('layouts.admin')

@section('title', ($item->exists ? 'Правка новости' : 'Новая новость') . ' · Админка')

@php $isEdit = $item->exists; @endphp

@section('admin-content')
    <h1 class="h1 mb-6">{{ $isEdit ? '✏️ Правка новости #' . $item->id : '✍️ Новая новость' }}</h1>

    <form method="POST"
          action="{{ $isEdit ? route('admin.news.update', $item) : route('admin.news.store') }}"
          class="card p-5 md:p-6 space-y-5 max-w-3xl">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label for="title" class="h3 block mb-2">Заголовок</label>
            <input id="title" name="title" maxlength="255" required class="field"
                   value="{{ old('title', $item->title) }}" placeholder="Отель обновился!">
            @error('title')<p class="small text-rose-300 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="body" class="h3 block mb-2">Текст</label>
            <textarea id="body" name="body" rows="8" required class="field"
                      placeholder="Что нового в отеле…">{{ old('body', $item->body) }}</textarea>
            @error('body')<p class="small text-rose-300 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label for="category" class="h3 block mb-2">Категория</label>
                <select id="category" name="category" class="field">
                    @foreach (['event' => '🎉 Событие', 'update' => '🔧 Обновление', 'contest' => '🏆 Конкурс'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('category', $item->category ?: 'event') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="image" class="h3 block mb-2">Картинка (URL, опционально)</label>
                <input id="image" name="image" maxlength="255" class="field"
                       value="{{ old('image', $item->image) }}" placeholder="https://…/promo.png">
            </div>
        </div>

        <label class="flex items-center gap-3 cursor-pointer select-none">
            <input type="hidden" name="featured" value="0">
            <input type="checkbox" name="featured" value="1" class="w-5 h-5 accent-fuchsia-500"
                   @checked(old('featured', $item->featured))>
            <span class="h3">⭐ Показывать крупно на главной</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button class="btn btn-cyan !py-3 !px-8">💾 {{ $isEdit ? 'Сохранить' : 'Опубликовать' }}</button>
            <a href="{{ route('admin.news.index') }}" class="btn-ghost !py-3 px-6 no-underline">Отмена</a>
        </div>
    </form>
@endsection
