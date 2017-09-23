<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 28.07.2017
 * Time: 23:22
 */

header('Content-Type: text/html; charset=utf-8');

/**
 * Load all necessary files
 */
require_once('autoload.php');

/**
 * @var gserver\core\Request
 */
$Request = Gserver()->Request();

/**
 * @var gserver\controllers\
 */
$Controller = $Request->getController();

/**
 * Includes the requested source code
 */
$Controller->loadTemplate($Request->getToInclude());

