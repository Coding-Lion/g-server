<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 25.11.2017
 * Time: 22:23
 */

declare(strict_types=1);

namespace gserver\components;

class Hashing
{
    /**
     * Contains the Instance
     *
     * @var Hashing|null
     */
    private static $Instance = NULL;

    /**
     * Hashing constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Config
     */
    public static function getInstance(): Hashing {

        if (self::$Instance === NULL) {
            self::$Instance = new Hashing();
        }

        return self::$Instance;

    }

    public function checkHash($plain,$hash): bool {
        return crypt($plain,$hash) === $hash ? true : false;
    }

    public function createHash($plain,$hash): string {
        return crypt($plain,$hash, PASSWORD_BCRYPT);
    }



}