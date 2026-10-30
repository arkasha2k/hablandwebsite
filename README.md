# Habland Hotel — Laravel CMS

CMS для ретро-отеля Habbo на Laravel 12. Работает с существующей таблицей `users`
(схема Arcturus-подобных эмуляторов: id, username, password, mail, account_created,
last_login, last_online, motto, look, gender, rank, credits, auth_ticket, ip_register, ip_current).

## Установка

```bash
composer create-project laravel/laravel habland-hotel
cd habland-hotel
```
Скопируй файлы из архива поверх созданного проекта (папки `app`, `routes`, `resources`).

```bash
cp .env.example .env
php artisan key:generate
# отредактируй .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan serve
```

## Настройка хеширования паролей

В `.env` выбери тип хранения паролей твоего эмулятора:

- `HASH_DRIVER=habbo-md5` — MD5 (Arcturus, Phoenix и большинство ретро) — **по умолчанию**
- `HASH_DRIVER=habbo-sha1` — SHA1
- `HASH_DRIVER=bcrypt` — стандартный Laravel (если пароли создавались через Laravel)

Драйвер регистрируется в `app/Providers/AppServiceProvider.php`.

## Маршруты

| Метод | Путь | Описание |
|---|---|---|
| GET | `/` | Главная |
| GET/POST | `/login` | Авторизация |
| GET/POST | `/register` | Регистрация |
| POST | `/logout` | Выход |
| GET | `/me` | Свой профиль (нужен вход) |
| GET | `/player/{username}` | Профиль любого игрока, напр. `/player/Vadim` |
| GET | `/players` | Список игроков с пагинацией |

## Важно

- Модель `User` использует `public $timestamps = false` — таблица без `created_at/updated_at`.
- Колонки времени (`account_created`, `last_login`, `last_online`) хранят Unix-timestamp — в кастах `datetime`.
- При регистрации `account_created` и `last_login` ставятся в `time()`, `ip_register`/`ip_current` — IP регистрации.
- Полный гайд по серверу Ubuntu: см. `UBUNTU_SERVER_GUIDE.md`.
# hablandwebsite
# hablandwebsite
