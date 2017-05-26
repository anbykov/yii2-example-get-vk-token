<?php

/**
* Упрощённый пример создания кнопки для получения токена для работы с API Вконтакте.
* Диалог подключения будет открываться в новом окне браузера.
* Для некоторых случаев может потребоваться передача дополнительной информации.
* В данном примере это значение JS-переменной strImemineCampaignId.

* @author Andrey Bykov
* @version 0.1
* @category Vk
*/

use yii\yii\helpers\Url;
?>

<button class="btn btn-primary" id="buttonAddVk">
    <?= Yii::t('frontend_imemine', 'button add vk');?>
</button>

<script>
    $('#buttonAddVk').on('click', function() {
        var strCabinetOauthUrl = '<?= Url::to(['v1/vk/cabinet-oauth2', 'strImemineCampaignId' => '']); ?>';
        window.open(strCabinetOauthUrl, 'connect_vk', "width=400, height=500, menubar=yes")
    })

    function recvVk(arrParameters) {
        arrParameters = arrParameters || {};
        // Отобразит значения из дочернего окна: adswitcher_campaign_id, vk_token, provider_auth_id, vk_userid
        console.log(arrParameters);
    }
</script>
