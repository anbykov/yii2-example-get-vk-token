<?php

/**
* Контроллер обеспечивающий получение токена для работы с API ВКонтакте
*
* @author Andrey Bykov
* @version 0.1
* @package VkAuthController
* @category Provider
*/

namespace frontend\controllers;

use yii;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use yii\authclient\OAuth2;
use yii\authclient\clients\VKontakte;

use frontend\models\ProviderAuth;
use frontend\models\Provider;


class VkAuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['logAction'] = [
            'class' => 'common\behaviors\ActionLogger'
        ];
        return $behaviors;
    }

    public function checkAccess()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Not allowed');
        } else {
            return true;
        };
    }

    /**
    * Редирект пользователя на страницы Вконтакте при запросе токена.
    *
    * @param string $strImemineCampaignId - идентификатор внутренней кампании (опциональный). Используется, если
    * нужно заменить токен Вконтакте на другой.
    */
    public function actionRequestOauth2Url($strImemineCampaignId=null)
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Not allowed');
        };

        $hashConfig = yii::$app->components;

        $oauthClient = new VKontakte();
        $oauthClient->clientId = $hashConfig['authClientCollection']['clients']['vkontakte']['clientId'];

        $oauthClient->setReturnUrl(Yii::$app->request->hostInfo .
                $hashConfig['authClientCollection']['clients']['vkontakte']['returnUri']);

        // Разрешает бессрочный доступ к API
        $oauthClient->scope = 'offline';

        $arrAdditionalQueryParameters = ['display' => 'mobile'];

        // Дополнительный параметр, например, идентификатор собственной кампании, для которой нужен доступ к API ВК
        if ($strImemineCampaignId) {
            $arrAdditionalQueryParameters['state'] = $strImemineCampaignId;
        };

        $url = $oauthClient->buildAuthUrl($arrAdditionalQueryParameters);
        Yii::$app->getResponse()->redirect($url);
    }

    /**
    * Получение токена от Вконтакте. Вызывается при редиректе, получаемом от Вконтакте.
    *
    */
    public function actionRecvToken()
    {
        $oauthClient = new VKontakte();
        $hashConfig = yii::$app->components;
        $oauthClient->clientId = $hashConfig['authClientCollection']['clients']['vkontakte']['clientId'];
        $oauthClient->clientSecret = $hashConfig['authClientCollection']['clients']['vkontakte']['clientSecret'];

        $oauthClient->setReturnUrl(Yii::$app->request->hostInfo .
                $hashConfig['authClientCollection']['clients']['vkontakte']['returnUri']);
        $strCode = Yii::$app->request->get('code');

        $oauthClient->validateAuthState = false;
        $accessToken = $oauthClient->fetchAccessToken($strCode);
        $hashAccessToken = $accessToken->params;
        $strImemineCampaignId = Yii::$app->request->get('state');

        // Сохранение полученных параметров для доступа к API
        $modelNewVkAuth = new ProviderAuth();
        $modelNewVkAuth->provider_id = Provider::getId(Provider::VK);
        $modelNewVkAuth->user_id = Yii::$app->user->id;
        $modelNewVkAuth->vk_token = $hashAccessToken['access_token'];
        $modelNewVkAuth->vk_userid = $hashAccessToken['user_id'];
        $modelNewVkAuth->save();

        $this->layout = 'main-minimal';
        return $this->render('recv-token',
                            ['model' => ['imemine_campaign_id' => $strImemineCampaignId,
                                        'provider_auth_id' => $modelNewVkAuth->id,
                                        'vk_token' => $modelNewVkAuth->vk_token,
                                        'vk_userid' => $modelNewVkAuth->vk_userid]]);
    }
}
