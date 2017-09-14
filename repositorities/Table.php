<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 14.09.2017
 * Time: 15:04
 */

namespace gserver\repositorities;


abstract class Table
{
    /**
     * @var Table|null
     */
    private static $Instance = NULL;

    /**
     * @var Db|null
     */
    private $Db = NULL;

    /**
     * Table constructor.
     */
    private function __construct() {
        $this->Db = Gserver()->Db();
    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Router
     */
    public static function getInstance() : Router {

        if (self::$Instance === NULL) {
            $Router = new Router();
            self::$Instance = $Router;
        }

        return self::$Instance;

    }

    /**
     * Returns the latest Dataset
     *
     * @return array
     */
    public function getDataset(): array {

        $vars = get_class_vars(__CLASS__);

        foreach ($vars as $key => &$value) {
            $function = 'get' . ucfirst($key);
            $value = $this->$function();
        }

        return $vars;

    }

    /**
     * Set all class properties from a Db result
     *
     * @param array $params
     */
    public function setDataset(array $params = []): void {

        $Reflection = new \ReflectionClass($this);
        $table = $Reflection->getShortName();

        if (empty($params)) {
            $row = $this->Db->fetchRow("SELECT * FROM " . $table);
        } else {

            if (count($params) !== 2) {
                // Failure
            }

            $key = array_shift($params);
            $value = array_shift($params);

            $row = $this->Db->fetchRow("SELECT * FROM " . $table . " WHERE " . $key . " = " . $value);

        }

        if (!empty($row)) {

            $vars = get_class_vars(__CLASS__);

            foreach ($row as $key => $value) {
                $function = 'set' . ucfirst(array_shift($vars));
                $this->$function($value);
            }

        } else {
            $this->setId(0);
        }

    }
}