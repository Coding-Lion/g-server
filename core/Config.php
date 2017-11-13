<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 00:43
 */

declare(strict_types=1);

namespace gserver\core;


final class Config
{
    /**
     * Contains the Instance
     *
     * @var Config|null
     */
    private static $Instance = NULL;

    /**
     * @var array
     */
    private $config = [];

    /**
     * Config constructor.
     */
    private function __construct() {

        $Db = Gserver()->Db();
        $this->config['core'] = $Db->fetchRow("SELECT * FROM config");
        $this->config['environment'] = $Db->fetchRow("SELECT * FROM environment WHERE active = ?",'yes');

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Config
     */
    public static function getInstance(): Config {

        if (self::$Instance === NULL) {
            self::$Instance = new Config();
        }

        return self::$Instance;

    }

    /**
     * @param string $config
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getConfig(string $config): array {

        if(!empty($this->config[$config])) {
            return $this->config[$config];
        }
        else {
            $info = debug_backtrace()[0];
            throw new \Exception("Config $config doesn't exist called in ".$info['file'].":".$info['line']);
        }

    }
}