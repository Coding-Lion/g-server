<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 14.09.2017
 * Time: 19:53
 */

declare(strict_types=1);

namespace gserver\repositories;

class TextModule extends Repository
{
    /**
     * @var TextModule|null
     */
    public static $Instance = NULL;

    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    public static function getInstance() : TextModule {

        if (self::$Instance === NULL) {
            self::$Instance = new TextModule();
        }

        return self::$Instance;

    }

}