<?php

/**
* Представление, которое открывается в дочернем окне после получения токена.
* В данном примере используется для передачи полученной информации в родительское окно и закрытия
* диалога подключения к API Вконтакте.
*
* @author Andrey Bykov
* @version 0.1
* @category Vk
*/
?>

<script>
    /**
    * Пример вызова функции, находящейся в пространстве имён родительского окна.
    * Может использоваться при передаче полученных значений в JS-часть.
    */
    opener.recvVk({"adswitcher_campaign_id": "<?= $model['imemine_campaign_id'] ?>",
                   "vk_token": "<?= $model['vk_token'] ?>",
                   "provider_auth_id": "<?= $model['provider_auth_id'] ?>",
                   "vk_userid": "<?= $model['vk_userid'] ?>"});
    window.close();
</script>
