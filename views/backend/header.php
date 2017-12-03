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
$locales = $Router->getAllLocale();
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
        <link href="https://examples.sencha.com/extjs/6.5.1/classic/theme-gray/resources/theme-gray-all.css" rel="stylesheet" />
        <link href="https://file.myfontastic.com/GD2azrej22ahMBUnaLjVk3/icons.css" rel="stylesheet">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/extjs/6.0.0/ext-all.js"></script>
        <script type="text/javascript" src=""></script>
