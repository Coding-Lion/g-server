<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 12:57
 */

declare(strict_types=1);

namespace gserver\repositories;


class Router extends Repository
{
    /**
     * @var Router|null
     */
    public static $Instance = NULL;

    /**
     * Router constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * @return Router
     */
    public static function getInstance() : Router {

        if (self::$Instance === NULL) {
            self::$Instance = new Router();
        }

        return self::$Instance;

    }

}