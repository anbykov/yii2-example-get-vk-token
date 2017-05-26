<?php

/**
* Конфигурация роутеров фронтенда для запроса и получения токена для работы с API Контакте
*
* @author Andrey Bykov
* @version 0.1
* @package
* @category Config
*/

return [
    'urlManager' => [
        'rules' => [
            'v1/vk/cabinet-oauth2' => 'vk-auth/request-oauth2-url',
            'v1/vk/cabinet-oauth2/<imemineCampaignId>' => 'vk-auth/request-oauth2-url',
            'v1/vk/recv-token' => 'vk-auth/recv-token',
        ],
    ],
];
