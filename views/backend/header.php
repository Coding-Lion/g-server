<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 25.09.2017
 * Time: 20:03
 */

/**
 * @var $this
 * is the active controller
 */

/**
 * @var array
 */
$core_config = Gserver()->Config()->getConfig('core');

/**
 * @var gserver\core\Router
 */
$Router = Gserver()->Router();

$locale = $Router->getLocale();
$mediaLink = $Router->getMediaLink();
$rootLink = $Router->getRootLink();

/**
 * @var gserver\core\TextModule
 */
$TextModule = Gserver()->TextModule();
$textBlocks = @$TextModule->textBlocks[$this->getName()];
$globals = $TextModule->textBlocks['global'];

/**
 * @var array
 */
$params = Gserver()->Request()->getParams();
?>

<!DOCTYPE html>
<html lang="<?=$locale?>">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?=$globals['servername']?> | <?=$globals[$this->getName()]?></title>

        <link rel="shortcut icon" href="<?=$mediaLink?>images/icons/favicon.ico" type="image/x-icon">


        <link href="https://cdnjs.cloudflare.com/ajax/libs/extjs/6.0.0/classic/theme-classic/resources/theme-classic-all.css" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/extjs/6.0.0/ext-all.js"></script>
        <script type="text/javascript">
            Ext.onReady(function () {
                Ext.create('Ext.window.Window', {
                    <?php if($this->getName() !== 'NotFound'): ?>
                    id: 'login_form',
                    title: '<?=$globals['servername']?> | <?=$globals[$this->getName()]?>',
                    titleAlign: 'center',
                    height: 200,
                    width: 400,
                    layout: 'auto',
                    items: [{
                        xtype: 'textfield',
                        name: 'name',
                        fieldLabel: '<?=$textBlocks['username']?>',
                        margin: '30 0 0 60',
                        allowBlank: false

                    }, {
                        xtype: 'textfield',
                        name: 'password',
                        inputType: 'password',
                        fieldLabel: '<?=$textBlocks['password']?>',
                        margin: '20 0 0 60',
                        allowBlank: false
                    }],
                    buttons: [{
                        xtype:'splitbutton',
                        text: '<?=$globals['language']?>',
                        menu: [{
                            icon: '<?=$mediaLink?>images/icons/de.png',text: 'Deutsch', href: '<?=$rootLink?>de/backend'
                        }, {
                            icon: '<?=$mediaLink?>images/icons/en.png',text: 'English', href: '<?=$rootLink?>en/backend'
                        }]
                    }, {
                        text: 'Login',
                        formBind: true,
                    }]
                    <?php else: ?>
                    id: 'not_found',
                    title: '<?=$globals['servername']?> | <?=$globals[$this->getName()]?>',
                    titleAlign: 'center',
                    height: 110,
                    width: 400,
                    layout: 'auto',
                    html: '<?=$textBlocks['headline']?>',
                    buttons: [{
                        xtype:'splitbutton',
                        text: '<?=$globals['language']?>',
                        menu: [{
                            icon: '<?=$mediaLink?>images/icons/de.png',text: 'Deutsch', href: '<?=$rootLink?>de/backend'
                        }, {
                            icon: '<?=$mediaLink?>images/icons/en.png',text: 'English', href: '<?=$rootLink?>en/backend'
                        }]
                    }, {
                        text: 'zur Startseite',
                        href: '<?=$rootLink.$locale?>/backend',
                    }]
                    <?php endif; ?>
                }).show();
            });
        </script>

    </head>
    <body style="background-color: #343a40 !important">