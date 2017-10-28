<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 03.10.2017
 * Time: 16:26
 */

namespace gserver\repositories;


abstract class Repository
{
    /**
     * @var array
     */
    private $loadedModels = [];

    /**
     * @param string $tableName
     *
     * @return mixed
     */
    public function getTable(string $tableName) {

        $modelPartPath = DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;

        require_once realpath(__DIR__ . $modelPartPath . 'Model.php');

        if (!in_array($tableName,$this->loadedModels)) {

            $file = realpath(__DIR__ . $modelPartPath . $tableName . '.php');
            require_once $file;
            array_push($this->loadedModels, $tableName);

        }

        $table = __NAMESPACE__ . $modelPartPath . $tableName;

        return $table::getInstance();

    }
}