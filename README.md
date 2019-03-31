# Учет материальных ценностей кафедры ВУЗа

## Рекомендуемые версии программного обеспечения

Система пишется при использовании фреймворка Phalcon языка программирования Phalcon

* Phalcon: 3.4.2
* PHP: 7.1+
* СУБД: MySQL или MariaDB

## Инструкция по установке

1. Склонируйте проект в папку вашего сервера

```sh
git clone https://github.com/AlukardBF/accounting.git
```

2. Выполните в папке с проектом

```sh
composer install
```

3. В файле

```sh
app/config/config.php
```

измените следующие настройки, чтобы они соответствовали вашему подключению к базе данных:

```php
'database' => [
    'adapter'     => 'Mysql',
    'host'        => 'localhost',
    'username'    => 'root',
    'password'    => '',
    'dbname'      => 'bachelor',
    'charset'     => 'utf8',
],
```

4. Если вы используете сервер apache установите baseUri, как

```php
'baseUri' => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
```

если же вы используете nginx установите baseUri, как

```php
'baseUri' => '/',
```