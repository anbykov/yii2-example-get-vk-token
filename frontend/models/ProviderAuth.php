<?php

/**
* Модель отвечающая за атрибуты доступа к API внешних провайдеров

* @author Andrey Bykov
* @version 0.1
* @package ProviderAuth
* @category Provider
*/

namespace frontend\models;

use yii\db\Query;
use \yii\db\ActiveRecord;

class ProviderAuth extends ActiveRecord
{
    public static function tableName()
    {
        return 'provider_auth';
    }

    public function fields()
    {
        return ['id', 'user_id', 'google_ccid', ];
    }

    /**
    * Валидация некоторых атрибутов
    */
    public function rules()
    {
        return [
                ['google_ccid', function ($attribute, $params) {
                    if (!preg_match('/^\d{3}\-\d{3}\-\d{4}$/', $this->$attribute)) {
                        $this->addError($attribute, 'Wrong Google CCID');
                    }
                }],
                [['id', 'user_id'], 'integer']
        ];
    }
}
