<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 15:13
 */

declare(strict_types=1);

namespace gserver\repositorities\session;


class Session
{
    /**
     * @var Session|null
     */
    public static $Instance = NULL;

    /**
     * @var array
     */
    private $loadedTables = [];

    /**
     * Session constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * @return Session
     */
    public static function getInstance() : Session {

        if (self::$Instance === NULL) {
            self::$Instance = new Session();
        }

        return self::$Instance;

    }

    /**
     * @param string $tablename
     *
     * @return mixed
     */
    public function getTable(string $tablename) {

        if (!in_array($tablename,$this->loadedTables)) {
            require_once('tables' . DIRECTORY_SEPARATOR . $tablename . '.php');
        }

        $table = __NAMESPACE__ . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . $tablename;

        return $table::getInstance();

    }
}