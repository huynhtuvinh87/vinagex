<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
$this->title = 'Xác thực số điện thoại';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <div>
            <input value="+1" id="country_code" />
            <input placeholder="phone number" id="phone_number"/>
            <button onclick="smsLogin();">Login via SMS</button>
        </div>
    </div>
</div>
<?= $this->registerJsFile('https://sdk.accountkit.com/en_US/sdk.js'); ?>
<?php ob_start(); ?>
<script>
    $(".message").append("<p>initialized Account Kit.</p>");
    // initialize Account Kit with CSRF protection
    AccountKit_OnInteractive = function () {
        AccountKit.init(
                {
                    appId: "986617248178890",
                    state: "eddefa5f21189a9f8a975237f03884b8",
                    version: "v1.0",
                    fbAppEventsEnabled: true
                }
        );
    };


    // login callback
    function loginCallback(response) {
        if (response.status === "PARTIALLY_AUTHENTICATED") {
            var code = response.code;
            var csrf = response.state;
            $(".message").append("<p>Received auth token from facebook -  " + code + ".</p>");
            $(".message").append("<p>Triggering AJAX for server-side validation.</p>");

            $.post("user/verify", {code: code, csrf: csrf}, function (result) {
                $(".message").append("<p>Server response : " + result + "</p>");
            });

        } else if (response.status === "NOT_AUTHENTICATED") {
            // handle authentication failure
            $(".message").append("<p>( Error ) NOT_AUTHENTICATED status received from facebook, something went wrong.</p>");
        } else if (response.status === "BAD_PARAMS") {
            // handle bad parameters
            $(".message").append("<p>( Error ) BAD_PARAMS status received from facebook, something went wrong.</p>");
        }
    }


    // phone form submission handler
    function smsLogin() {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        $(".message").append("<p>Triggering phone validation.</p>");
        AccountKit.login(
                'PHONE',
                {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
                loginCallback
                );
    }

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>