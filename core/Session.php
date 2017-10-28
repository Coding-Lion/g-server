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
    private function __construct() {

        $this->Repository = Gserver()->RepositoryManager(['namespace' => 'repositories',
            'repository' => 'Session'])->getRepository();

        session_start();

        $Table = $this->Repository->getTable('user');

        $Table->setDataSet(['sessionId', session_id()]);

        $user = $Table->getDataSet();

        if ($user['id'] === 0) {
            $user['account']['SecurityLevel'] = -1;
        }

        $this->setUser($user);

    }

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
            self::$Instance = new Session();
        }

        return self::$Instance;

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