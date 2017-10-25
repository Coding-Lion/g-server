<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 12:01
 */

declare(strict_types=1);

namespace gserver\repositorities;


final class RepositoryManager
{
    /**
     * @var RepositoryManager|null
     */
    public static $Instance = NULL;

    /**
     * @var array
     */
    private $loadedRepositorities = [];

    /**
     * @var obejct|null
     */
    private $Repository = NULL;

    /**
     * RepositoryManager constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * @param string $repository
     *
     * @return RepositoryManager
     */
    public static function getInstance(string $repository) : RepositoryManager {

        if (self::$Instance === NULL) {
            self::$Instance = new RepositoryManager();
        }

        if(!in_array($repository, self::$Instance->loadedRepositorities)) {
            self::$Instance->Repository = self::$Instance->loadNewRepository($repository);
            array_push(self::$Instance->loadedRepositorities,$repository);
        } else {
            self::$Instance->Repository = self::$Instance->getClass($repository)::getInstance();
        }

        return self::$Instance;

    }

    /**
     * @param string $repository
     *
     * @return mixed
     */
    private function loadNewRepository(string $repository) {

        require_once(strtoupper($repository.'.php'));
        $class = $this->getClass($repository);

        return $class::getInstance();

    }

    /**
     * @return object|null
     */
    public function getRepository() {
        return $this->Repository;
    }

    /**
     * @param string $repository
     *
     * @return string
     */
    private function getClass(string $repository): string {
        return __NAMESPACE__ . DIRECTORY_SEPARATOR . strtolower($repository);
    }
}