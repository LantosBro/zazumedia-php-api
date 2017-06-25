<?php
require_once 'Zazumedia.php';

/**
 * Пример использования класса Zazumedia.php
 * Для работы необходимо создать файл с токеном и указать к нему путь
 */

try {

    $login = 'info@zazumedia.ru';
    $path = $_SERVER['DOCUMENT_ROOT'] . '/../' . $login;

    $zazu = new Zazumedia( $login );
    $info = $zazu->getInfo();

    var_dump($info);

} catch( Exception $e ) {
    echo $e->getMessage();
}