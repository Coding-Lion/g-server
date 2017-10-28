<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 16:10
 */

?>
<div class='access_container'>
<?php

    if ($core_config['server'] === "private") {
        echo $textBlocks['access_headline_private'];
    } else {
        echo $textBlocks['access_headline_public'];
    }

    if ($core_config['web_register_allow'] === "yes") {
        require_once "register.php";
    } else {
        echo $textBlocks['register_is_not_allow'];
    }

    if ($core_config['web_login_allow'] === "yes") {
        require_once "login.php";
    } else {
        echo $textBlocks['login_is_not_allow'];
    }

?>
</div>