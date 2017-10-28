<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 15:13
 */

declare(strict_types=1);

namespace gserver\repositories;


class Session extends Repository
{
    /**
     * @var Session|null
     */
    public static $Instance = NULL;

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

}