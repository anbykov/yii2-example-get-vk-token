<?php

/**
* Логгер действий пользователя
*
* Производит сохранение названия контроллера, к которому делается обращение.
* @author Andrey Bykov
* @version 0.1
* @package ActionLogger
* @category Logging
*/

namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\web\Controller;
use common\models\ActionLog;

class ActionLogger extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'logAction',
        ];
    }

    public function logAction()
    {
        if (!Yii::$app->user->isGuest) {
            $loggerModel = new ActionLog();
            $loggerModel->strActionName = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id ;
            $loggerModel->logAction();
        }
    }
}
