# Zmtech (php) Api class

## Описание

Пример реализации API интерфейса сервиса массовых SMS / Viber рассылок

## Установка
```cmd
git clone git@github.com:zmtechru/api-php-class
```
## Быстрый старт

```php
<?php
require_once 'Zmtech.php';
try {
    
    $id = '1';
    $key = '6Imh0dHBzOi8vZ28uemF6dW1lZGlhLnJ1L3Byb2ZpbGUvdG9rZW4i';
    
    $zazu = new Zmtech($id, $key);
    $info = $zazu->getInfo();
    
    var_dump($info);
    
} catch( Exception $e ) {
    echo $e->getMessage();
}
```