<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

/**
 * 🆕 НОВЫЙ ФАЙЛ: app/Http/Controllers/NewsController.php
 */
class NewsController extends Controller
{
    // Лента новостей (лента + пагинация)
    public function index(Request $request)
    {
        $news = News::published()->paginate(8)->withQueryString();

        return view('news.index', [
            'news'  => $news,
            'total' => News::count(),
        ]);
    }

    // Одна новость
    public function show(int $id)
    {
        $item = News::published()->findOrFail($id);

        // «Ещё почитать» — три более ранние новости
        $related = News::published()->where('id', '!=', $item->id)->limit(3)->get();

        return view('news.show', compact('item', 'related'));
    }
}
