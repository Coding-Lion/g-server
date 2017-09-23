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
    public static function getInstance(): Config {

        if (self::$Instance === NULL) {

            $Config = new Config();
            $Config->loadConfigs();
            self::$Instance = $Config;

        }

        return self::$Instance;

    }

    /**
     * TODO: Implement another configs
     *
     * Hint: The core config can't modify over the frontend which means no Repository class exists
     *
     * Load all configs
     */
    private function loadConfigs(): void {
        $Db = Gserver()->Db();
        $this->config['core'] = $Db->fetchRow("SELECT * FROM config");
    }

    /**
     * @param string $config
     *
     * @return array
     */
    public function getConfig(string $config): array {

        if (is_array($this->config[$config])) {
            return $this->config[$config];
        } else {
            // Failure|Warning
        }

    }
}