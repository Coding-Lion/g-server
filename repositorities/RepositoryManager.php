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
    public static $Instance = NULL;

    private $loadedRepositorities = [];

    private $Repository = NULL;

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
            $RepositoryManager = new RepositoryManager();
            self::$Instance = $RepositoryManager;
        }

        if(!in_array($repository, self::$Instance->loadedRepositorities)) {
            self::$Instance->Repository = self::$Instance->loadNewRepository($repository);
            array_push(self::$Instance->loadedRepositorities,$repository);
        } else {
            self::$Instance->Repository = self::$Instance->getClass($repository)::getInstance();
        }

        return self::$Instance;

    }

    private function loadNewRepository(string $repository) {

        require_once($repository . DIRECTORY_SEPARATOR . 'Repository.php');

        $class = $this->getClass($repository);

        return $class::getInstance();

    }

    public function getRepository() {
        return $this->Repository;
    }

    private function getClass(string $repository): string {
        return __NAMESPACE__ . DIRECTORY_SEPARATOR . strtolower($repository) . DIRECTORY_SEPARATOR . 'Repository';
    }
}