<?php

use Illuminate\Database\Seeder;
use App\Models\News;

/**
 * 🆕 НОВЫЙ ФАЙЛ: database/seeders/NewsSeeder.php
 * Демо-новости для разработки. На проде можно удалить или использовать как шаблон.
 * Запуск: php artisan db:seed --class=NewsSeeder
 */
return new class extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Отель открывается! 🎉',
                'body' => "Друзья, Habland Hotel официально открыт!\n\nРегистрируйтесь, выбирайте причёску помоднее, обставляйте комнату и зовите друзей. Мы стартовали совсем недавно, но уже готовы к большим тусовкам.",
                'category' => 'event',
                'featured' => true,
                'days_ago' => 1,
            ],
            [
                'title' => 'Обновление каталога: новая мебель 🛋️',
                'body' => "В каталог добавлены 24 новых предмета: неоновые диваны, аркадные автоматы и бассейн «Лагуна».\n\nВсе новинки уже доступны в магазине отеля.",
                'category' => 'update',
                'featured' => false,
                'days_ago' => 3,
            ],
            [
                'title' => 'Конкурс на лучшую комнату недели 🏆',
                'body' => "Постройте самую крутую комнату и получите 5000 кредитов! Победителя выберем в пятницу голосованием жителей.\n\nУсловия простые: комната должна быть открыта для гостей.",
                'category' => 'contest',
                'featured' => false,
                'days_ago' => 5,
            ],
            [
                'title' => 'Ночной клуб «Пиксель» приглашает 🪩',
                'body' => "Каждую субботу в 21:00 — дискотека в клубе «Пиксель». DJ PixelMix ставит лучшие чиптюн-хиты. Вход свободный, дресс-код — стильный.",
                'category' => 'event',
                'featured' => false,
                'days_ago' => 7,
            ],
            [
                'title' => 'Исправления и мелкие улучшения 🔧',
                'body' => "На этой неделе:\n— починили пагинацию в списке игроков;\n— добавили поиск по нику и девизу;\n— аватары теперь всегда на месте (эмодзи-заглушки).\n\nСпасибо за баг-репорты!",
                'category' => 'update',
                'featured' => false,
                'days_ago' => 9,
            ],
        ];

        foreach ($items as $it) {
            News::create([
                'title'          => $it['title'],
                'body'           => $it['body'],
                'category'       => $it['category'],
                'featured'       => $it['featured'],
                'created_at_int' => now()->subDays($it['days_ago'])->timestamp,
            ]);
        }
    }
};
