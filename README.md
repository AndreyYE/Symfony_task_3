1) Зайдите в файл .env и установите ваши данные для базы данных.
2) Наберите в консоли корня проекта composer update.
3) Наберите в консоли корня проекта yarn install.
4) Наберите в консоли корня проекта php bin/console doctrine:database:create - Это создаст базу данных.
5) Наберите в консоли корня проекта php bin/console doctrine:migrations:migrate - Это создаст таблицы в базе данных.
6) Зайдите в файл /cmd/src/Env.php и установите ваши данные для базы данных.
7) Зайдите в файл /cmd/composer.json и добавте к пункт require : 
"suncat/symfony-console-extra": "1.0.*@dev",
"doctrine/orm": "2.4.x-dev",
"doctrine/collections": "v1.1",
"doctrine/dbal": "v2.4.0",
"symfony/yaml": "2.1.x-dev" .
8) Наберите в консоли корня проекта cd cmd.
9) Наберите в консоли composer update.
10) Наберите в консоле php app/console orders {количество заказвов} - Это создаст записи в таблице orders и order_items.
Если вы хотите создать 5 заказов вам нужно набрать php cmd/app/console orders 5 .
11) Наслаждайтесь.