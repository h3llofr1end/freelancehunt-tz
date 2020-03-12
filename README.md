Для работы с проектом необходимо
1. Обновить зависимости composer командой composer update
2. Выполнить скрипт db/freelancehunt.sql для создания базы
3. Выполнить команду cp .env.example .env
4. Заполнить настройки базы данных и указать API-токен FreelanceHunt API
5. Для обновления базы необходимо выполнить команду php db/refresh-db.php
6. Запустить локальный сервер php -S localhost:8000
7. Перейти, на главной откроется весь необходимый функционал
8. Выполнение тестов(Win10) - "./vendor/bin/phpunit" tests