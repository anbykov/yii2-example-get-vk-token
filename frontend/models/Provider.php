<?php

/**
* Модель отвечающая за провайдеров внешних API

* @author Andrey Bykov
* @version 0.1
* @package Provider
* @category Provider
*/

namespace frontend\models;

use \yii\db\ActiveRecord;

class Provider extends ActiveRecord
{
    /**
    * Название для провайдера Google AdWords
    *
    * @ADWORDS string
    */
    const ADWORDS = 'Google AdWords';

    /**
    * Название для провайдера Вконтакте
    *
    * @VK string
    */
    const VK = 'VK';

    public static function tableName()
    {
        return 'provider';
    }

    /**
    * Получение id внешнего провайдера по названию
    *
    * @param string $strName - название внешнего провайде
    * @return int
    */
    public static function getId($strName)
    {
        $result = self::findOne(['name' => $strName]);
        if ($result) {
            return $result->id;
        }
        return null;
    }
}
