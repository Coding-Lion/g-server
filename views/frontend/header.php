<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 13:35
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
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <?php if(ENVIRONMENT['show_debug_console'] === 'yes'): ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/extjs/6.0.0/classic/theme-classic/resources/theme-classic-all.css" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/extjs/6.0.0/ext-all.js"></script>
        <script type="text/javascript">
            Ext.onReady(function () {
                var win = Ext.create('Ext.window.Window', {
                    id: 'debug_console',
                    title: '<?=$globals['servername']?> | Debug Console',
                    titleAlign: 'center',
                    height: 'auto',
                    width: 250,
                    x: 1670,
                    y: 0,
                    layout: 'auto',
                    html: "<?php
                        $var = '';
                        echo '<p><b>$var</b></p>';
                        if(is_array($var) || is_object($var)) {
                            foreach($core_config as $key => $val) echo '<b>'.$key.':</b> '.$val.'<br>';
                        }
                        else {
                            echo $var;
                        }
                    ?>"
                }).show();
            });
        </script>
        <?php endif; ?>
    </head>
    <body class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <img src="<?=$mediaLink?>images/icons/g-server_32.png" />
        <a class="navbar-brand" href="<?=$rootLink?>" title="<?=$globals['servername']?>" style="margin-bottom:6px; padding-left:4px;"><?=$globals['servername']?></a>
    </nav>
    <div class="container" style="margin-top:70px; text-align:center; color:#FFF;">