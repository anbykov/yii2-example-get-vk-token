<?php

/**
* Конфигурация модуля yii\authclient\clients\VKontakte в приложении для работы с VK.
*
* Приведены только требуемые для работы с ВК параметры.
* @author Andrey Bykov
* @version 0.1
* @package
* @category Config
*/

return [
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'authUrl' => 'http://api.vk.com/oauth/authorize',
                    'tokenUrl' => 'https://api.vk.com/oauth/access_token',
                    'returnUri' => '/v1/vk/recv-token', // Доверенный redirect URL (часть после имени хоста)
                    'clientId' => '', // ID приложения
                    'clientSecret' => '', // Защищённый ключ
                ],
            ],
        ],
    ],
];
