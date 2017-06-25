# Zazumedia (php) Api class

## Описание

Пример реализации API интерфейса сервиса [go.zazumedia.ru](https://go.zazumedia.ru)

Предназначен для отправки сервисных сообщений. 

[Документация](http://docs.zazumedia.ru)

## Установка
```cmd
git clone git@github.com:zazumedia/api-php-class
```
## Быстрый старт

Для каждого логина, через который происходит соединение, должен быть файл с именем {ваш логин}, содержимым которого является `token`.

Новый token можно получить [здесь](https://go.zazumedia.ru/profile/edit).

Обратите внимание, файл с токеном не должен быть доступен по http!

```php
<?php
require_once 'Zazumedia.php';
try {
    
    $login = 'info@zazumedia.ru';
    $path = $_SERVER['DOCUMENT_ROOT'] . '/../' . $login;
    
    $zazu = new Zazumedia( $login );
    $info = $zazu->getInfo();
    
    var_dump($info);
    
} catch( Exception $e ) {
    echo $e->getMessage();
}
```