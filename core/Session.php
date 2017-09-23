<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 13:15
 */

declare(strict_types=1);

namespace gserver\core;


final class Session
{
    /**
     * Contains the Instance
     *
     * @var Session|null
     */
    private static $Instance = NULL;

    /**
     * @var array
     */
    private $user = [];

    /**
     * Session constructor.
     */
    private function __construct() {}

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Session
     */
    public static function getInstance(): Session {

        if (self::$Instance === NULL) {

            $Session = new Session();

            $Reflection = new \ReflectionClass($Session);

            $Session->Repository = Gserver()->RepositoryManager(
                ['namespace' => 'repositorities',
                    'repositority' => $Reflection->getShortName()]
            )->getRepository();

            $Session->loadSession();
            self::$Instance = $Session;

        }

        return self::$Instance;

    }

    /**
     * Load the session for the current user with account details which includes his access permission
     */
    private function loadSession(): void {

        session_start();

        $Table = $this->Repository->getTable('user');

        $Table->setDataset(['sessionId', session_id()]);

        $user = $Table->getDataset();

        if ($user['id'] === 0) {
            $user['account']['SecurityLevel'] = -1;
        }

        $this->setUser($user);
    }

    /**
     * @param array $user
     */
    private function setUser(array $user) {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getUser(): array {
        return $this->user;
    }
}