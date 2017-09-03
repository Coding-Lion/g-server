<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 12:57
 */

declare(strict_types=1);

namespace gserver\repositorities\router;


class Repository
{
    public static $Instance = NULL;

    private $loadedTables = [];

    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    public static function getInstance() : Repository {

        if (self::$Instance === NULL) {
            $Repository = new Repository();
            self::$Instance = $Repository;
        }

        return self::$Instance;

    }

    public function getTable(string $tablename) {

        if (!in_array($tablename,$this->loadedTables)) {
            require_once('tables' . DIRECTORY_SEPARATOR . $tablename . '.php');
        }

        $table = __NAMESPACE__ . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . $tablename;

        return new $table();

    }
}