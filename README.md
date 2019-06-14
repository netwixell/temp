## Окружение

1. PHP7.2, node.js(version 8 and later)
2. MySQL, Redis,
3. Composer, NPM
4. Laravel Homestead/Open Server/Nginx/Apache/etc...

## Развертывание проекта

1. `git clone git@bitbucket.org:kontoradesign/c-lab.git`, `cd c-lab`
2. `git checkout develop`
3. `npm i`
4. `composer install`
5. Создать файл с настройками окружения .env `cp .env.example .env`, `php artisan key:generate` и внести настройки подключения к БД
6. Создать symlink папки storage `php artisan storage:link`
  * Чтобы создать symlink на windows нужно установить [Link Shell Extension](http://schinagl.priv.at/nt/hardlinkshellext/linkshellextension.html).
  Целевая папка: `storage/app/public`. Адрес symlink: `public/storage`

## Запуск

1. `gulp` - сборка frontend-файлов для разработки
2. `gulp admin-panel` - сборка frontend-файлов для админки
3. `gulp client-email` - сборка frontend-файлов для отправлямых писем клиентам
4. `gulp pdf` - сборка frontend-файлов для генерирования pdf
5. `gulp build` - сборка frontend-файлов для деплоя сайта
6. `php artisan serve` - запуск Laravel backend-сервера
