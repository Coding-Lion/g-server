<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 03.10.2017
 * Time: 16:26
 */

namespace gserver\repositorities;


abstract class Repository
{
    /**
     * @param string $tableName
     *
     * @return mixed
     */
    public function getTable(string $tableName) {

        if (!in_array($tableName,$this->loadedTables)) {

            $file = realpath(__DIR__ . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . $tableName . '.php');
            require_once($file);
            array_push($this->loadedTables, $tableName);

        }

        $table = __NAMESPACE__ . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . $tableName;

        return $table::getInstance();

    }
}