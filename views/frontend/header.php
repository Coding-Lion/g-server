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
 * @var string
 */
$locale = Gserver()->Router()->getLocale();

/**
 * @var gserver\core\TextModule
 */
$TextModule = Gserver()->TextModule();
$textblocks = $TextModule->textblocks[$this->getName()];
$globals = $TextModule->textblocks['global'];

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

        <title><?=$globals['servername']?> | <?=$this->getName()?></title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    </head>
    <body class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#"><?=$globals['servername']?></a>
    </nav>
    <div class="container" style="margin-top:80px; text-align:center; color:#FFF;">