<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 10:44
 */

declare(strict_types=1);

namespace gserver\core;


final class Gserver
{
    /**
     * @var Gserver|null
     */
    public static $Instance = NULL;

    /**
     * Gserver constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Gserver
     */
    public static function getInstance(): Gserver {

        if (self::$Instance === NULL) {
            $Gserver = new Gserver();
            self::$Instance = $Gserver;
        }

        return self::$Instance;

    }

    /**
     * Returns the instance of the called class
     *
     * @param $name
     * @param $params
     *
     * @return mixed
     */
    public function __call($name,$params) {

        $class = __NAMESPACE__ . DIRECTORY_SEPARATOR . $name;

        if (empty($params)) {
            $Instance = $class::getInstance();
        } else {

            $param = array_shift($params);

            if (is_string($param)) {
                $Instance = $class::getInstance($param);
            } elseif(is_array($param) && array_key_exists('namespace',$param)) {

                // TODO: find another solution with more performance
                $Reflection = new \ReflectionClass($this);

                $namespace = strtolower($Reflection->getShortName()) . DIRECTORY_SEPARATOR . array_shift($param);
                $class = $namespace . DIRECTORY_SEPARATOR . $name;

                if(empty($param)) {
                    $Instance = $class::getInstance();
                } else {
                    $Instance = $class::getInstance(array_shift($param));
                }

            } else {
                // Failure
            }

        }

        return $Instance;

    }


}