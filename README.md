Получение Oauth2 токена для взаимодействия с API ВКонтакте средствами Yii2
==========

Пример показывает решение этой задачи средствами Yii2. 
Приводится, в основном, код, имеющий отношение к получению токена. Используется advanced-темплейт.
Id вашего приложения ВК и его ключ, полученные на сайте ВК при регистрации приложения, указываются в `common/config/main.php`.

Получение токена для работы с API ВКонтакте состоит из следующих этапов:
- приложение Yii формирует URL, который несёт информацию о приложении (id приложения и его ключ) для перехода к ресурсам ВК;
- пользователь переходит к службам ВК по URL сформированному на предыдущем шаге;
- ВК запрашивает у пользователя его регистрационные данные и разрешение использования ВК-ресурсов приложению Yii (обычно это происходит в новом окне браузера);
- ВК формирует URL, который содержит токен для доступа через API;
- пользователь перенаправляется на сформированный URL;
- приложение Yii получает токен из поступившего get-запроса.

Со стороны Yii-приложения задача получения токена доступа к API Вконтакте состоит в:
- формировании URL и редиректа пользователя к ВК (`frontend\controllers\VkAuthController.actionRequestOauth2Url()`);
- контроллера и представления, обеспечивающих получение токена из get-запроса при редиректе пользователя из ВК (`frontend\controllers\VkAuthController.actionRecvToken()`).

Значение единственного аргумента, опционально передаваемого `actionRequestOauth2Url()`, возвращается вместе с токеном в get-запросе в параметре `state` при редиректе пользователя с ВК. Это значение может быть использовано для идентификации сущности, к которой относится принятый токен. Например, это могут быть собственные кампании внутри Yii-приложения.

Дополнительно в `common\behaviors\ActionLogger` показан пример поведения для простого логгирования действий, которое ведётся только для зарегистрированных пользователей. При логгировании в таблицу action_log помещаются время, id пользователя и название действия в виде строки формата `название контроллера / название действия`. 