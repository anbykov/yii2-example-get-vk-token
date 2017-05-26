<?php

/**
* Модель для логирования действий пользователя
*
* Сохраняется время, id пользователя и название действия в виде строки с форматом controller/action
*
* @author Andrey Bykov
* @version 0.1
* @package ActionLog
* @category Logging
*/

namespace common\models;
use \yii\db\ActiveRecord;

class ActionLog extends ActiveRecord
{
    /**
    * @var String Название действия в формате контроллер/действие
    */
    public $strActionName;

    public static function tableName()
    {
        return 'action_log';
    }

    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'integer'],
            [['action'], 'string', 'max' => 256],
        ];
    }

    /**
    * Сохранение записи в лог
    */
    public function logAction()
    {
        $this->action = $this->strActionName;
        $this->user_id = Yii::$app->user->id;
        $this->created_at = time();
        $this->save();
        return true;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'created_at' => 'Created At',
        ];
    }

    public static function find()
    {
        return new ActionLogQuery(get_called_class());
    }
}
