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
    </head>
    <body class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <img src="<?=$mediaLink?>images/icons/g-server_32.png" />
        <a class="navbar-brand" href="<?=$rootLink?>" title="<?=$globals['servername']?>" style="margin-bottom:6px; padding-left:4px;"><?=$globals['servername']?></a>
    </nav>
    <div class="container" style="margin-top:70px; text-align:center; color:#FFF;">