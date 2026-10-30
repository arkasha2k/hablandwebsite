# Гайд: Ubuntu Server для Habland Hotel (Laravel + MySQL + Nginx)

Рекомендуемая ОС: **Ubuntu Server 24.04 LTS**. Стек: **PHP 8.3**, **MySQL 8.0**, **Nginx**, **Composer 2**.

## 1. Обновление системы

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl wget unzip git software-properties-common
```

## 2. Установка PHP 8.3 + нужные модули

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-fpm php8.3-cli php8.3-common   php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip   php8.3-gd php8.3-bcmath php8.3-intl php8.3-readline
php -v   # должно быть 8.3.x
php -m   # проверить: pdo_mysql, mbstring, openssl, tokenizer, xml, curl, gd
```

## 3. Установка MySQL 8.0

```bash
sudo apt install -y mysql-server
sudo mysql_secure_installation   # задать пароль root, отключить anonymous
sudo mysql -u root -p
```

```sql
CREATE DATABASE hablandhotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'habland'@'localhost' IDENTIFIED BY 'СЕКРЕТНЫЙ_ПАРОЛЬ';
GRANT ALL PRIVILEGES ON hablandhotel.* TO 'habland'@'localhost';
FLUSH PRIVILEGES;
```

Если база с пользователями уже существует на этом же сервере — просто создай отдельного юзера или используй существующего.

## 4. Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

## 5. Развёртывание проекта

```bash
cd /var/www
sudo git clone https://github.com/ТВОЙ_РЕПО/habland-hotel.git habland-hotel
# или закинуть архив: sudo unzip habland-hotel.zip -d habland-hotel
cd habland-hotel

composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
```

### .env (ключевые строки)

```ini
APP_NAME="Habland Hotel"
APP_URL=https://hablandhotel.ru
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hablandhotel
DB_USERNAME=habland
DB_PASSWORD=СЕКРЕТНЫЙ_ПАРОЛЬ

HASH_DRIVER=habbo-md5
SESSION_SECURE_COOKIE=true
```

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 6. Права доступа

```bash
sudo chown -R www-data:www-data /var/www/habland-hotel
sudo chmod -R 775 storage bootstrap/cache
```

## 7. Nginx + PHP-FPM

```bash
sudo apt install -y nginx
sudo nano /etc/nginx/sites-available/hablandhotel
```

```nginx
server {
    listen 80;
    server_name hablandhotel.ru www.hablandhotel.ru;
    root /var/www/habland-hotel/public;
    index index.php;

    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* { deny all; }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/hablandhotel /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

## 8. HTTPS (Certbot / Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d hablandhotel.ru -d www.hablandhotel.ru
```

## 9. Cron для Laravel Scheduler (опционально)

```bash
sudo crontab -e
# добавить строку:
* * * * * cd /var/www/habland-hotel && php artisan schedule:run >> /dev/null 2>&1
```

## Итоговая версия

| Компонент | Версия |
|---|---|
| Ubuntu | 24.04 LTS |
| PHP | 8.3 (FPM) |
| MySQL | 8.0 |
| Nginx | latest из репо |
| Composer | 2.x |
| Laravel | 12.x |
