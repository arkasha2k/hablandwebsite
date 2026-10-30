<?php

namespace App\Providers;

use Illuminate\Hashing\AbstractHasher;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Собственная тема пагинации: resources/views/vendor/pagination/default.blade.php
        Paginator::defaultView('pagination::default');
        Paginator::defaultSimpleView('pagination::simple-default');
        // Драйвер под ретро-отели: пароли в БД чаще всего хранятся как md5(пароль)
        Hash::extend('habbo-md5', fn () => new class extends AbstractHasher {
            public function make(#[\SensitiveParameter] $value, array $options = []): string
            {
                return md5($value);
            }

            public function check(#[\SensitiveParameter] $value, $hashedValue, array $options = []): bool
            {
                return hash_equals((string) $hashedValue, md5($value));
            }

            public function needsRehash($hashedValue, array $options = []): bool
            {
                return false;
            }
        });

        Hash::extend('habbo-sha1', fn () => new class extends AbstractHasher {
            public function make(#[\SensitiveParameter] $value, array $options = []): string
            {
                return sha1($value);
            }

            public function check(#[\SensitiveParameter] $value, $hashedValue, array $options = []): bool
            {
                return hash_equals((string) $hashedValue, sha1($value));
            }

            public function needsRehash($hashedValue, array $options = []): bool
            {
                return false;
            }
        });
    }
}
