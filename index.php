<?php
require_once 'Zmtech.php';

/**
 * Пример использования класса Zmtech.php
 */

try {

    $id = '1';
    $key = '6Imh0dHBzOi8vZ28uemF6dW1lZGlhLnJ1L3Byb2ZpbGUvdG9rZW4i';

    // Получить инфо об авторизованном аккаунте
    $zmtech = new Zmtech( $id, $key );
    $info = $zmtech->getInfo();
    var_dump( $info );

    // Отправить одно Sms
    $response = $zmtech->sendSms( [
        'phone' => '79112223344',
        'message' => 'test sms',
        'sender' => 'zmtech.ru'
    ] );

    // Отправить несоколько Sms (до 100 штук)
    $response = $zmtech->sendSms( [
        [
            'phone' => '79112223344',
            'message' => 'test sms',
            'sender' => 'zmtech.ru'
        ], [
            'phone' => '79112223345',
            'message' => 'test sms 2',
            'sender' => 'zmtech.ru'
        ]
    ] );

    // Отправить одно сообщение Viber
    $response = $zmtech->sendViber( [
        'phone' => '79112223344',
        'message' => 'test viber',
        'btntext' => 'zmtech.ru',
        'btnlink' => 'http://zmtech.ru',
        'picpath' => 'http://zmtech.ru/logo.png'
    ] );

    // Отправить несоколько сообщений Viber (до 100 штук)
    $response = $zmtech->sendViber( [
        [
            'phone' => '79112223344',
            'message' => 'test viber',
            'btntext' => 'zmtech.ru',
            'btnlink' => 'http://zmtech.ru',
            'picpath' => 'http://zmtech.ru/logo.png'
        ], [
            'phone' => '79112223345',
            'message' => 'test viber 2',
            'btntext' => 'zmtech.ru',
            'btnlink' => 'http://zmtech.ru',
            'picpath' => 'http://zmtech.ru/logo.png'
        ]
    ] );

    // Запросить статусы
    $statuses = $zmtech->getStatuses();
    var_dump( $statuses );

} catch ( Exception $e ) {
    echo $e->getMessage();
}