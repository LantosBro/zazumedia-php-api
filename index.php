<?php
require_once 'Zmtech.php';

/**
 * Пример использования класса Zmtech.php
 * Для работы необходимо создать файл с токеном и указать к нему путь
 */

try {

    $id = '1';
    $key = '6Imh0dHBzOi8vZ28uemF6dW1lZGlhLnJ1L3Byb2ZpbGUvdG9rZW4i';

    $zazu = new Zmtech($id, $key);
    $info = $zazu->getInfo();

    var_dump($info);

} catch( Exception $e ) {
    echo $e->getMessage();
}