<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 10:51
 */

$directories = ['configs', 'core', 'repositorities'];

/**
 * Load all files in the given directories
 */
foreach($directories as $directory) {

    $handle = opendir($directory);

    while (false !== ($entry = readdir($handle))) {

        if ($entry === '.' || $entry === '..' || substr($entry,-4) !== '.php') {
            continue;
        }

        require_once($directory . DIRECTORY_SEPARATOR . $entry);

    }
}

/**
 * Returns the Gserver instance
 *
 * @return \gserver\core\Gserver
 */
function Gserver() {
    return \gserver\core\Gserver::getInstance();
}