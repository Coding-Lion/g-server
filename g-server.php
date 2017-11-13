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
require_once 'autoload.php';

$module = strpos($_SERVER['REQUEST_URI'], 'backend') !== false ? 'backend' : 'frontend';

Gserver()->Db($module);

$Config = Gserver()->Config();

define("ENVIRONMENT",$Config->getConfig('environment'));
define("CORE",$Config->getConfig('core'));

//<editor-fold desc="Environment configuration"

// comming soon
ini_set('display_errors', ENVIRONMENT['show_exceptions']);

//</editor-fold>

//<editor-fold desc="Preparing requested uri"

$fileParts = explode(DIRECTORY_SEPARATOR, __FILE__);
$fName = end($fileParts);
$search = str_replace($fName, '', $_SERVER['SCRIPT_NAME']);
$_SERVER['SUBDIRECTORY'] = $search;

// No need for the directory in the url where the server is located
$uri = $_SERVER['REDIRECT_URL'];
$uri = strtolower(str_replace($search, '', $uri));
$_SERVER['REDIRECT_URL'] = substr($uri, -1) === '/' ? substr($uri, 0, -1) : $uri;

//</editor-fold>

// Check for maintenance and redirect if needed
if (CORE['web_maintenance'] === 'yes' && $_SERVER['REDIRECT_URL'] !== 'maintenance') {
    header('Location: localhost/g-server/maintenance');
    exit();
}

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

