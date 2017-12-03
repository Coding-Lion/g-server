<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 15:12
 */

declare(strict_types=1);

namespace gserver\repositories\models;


/**
 * Table_prefix_user
 */
class user extends Model
{
    /**
     * @var user|null
     */
    private static $Instance = NULL;

    /**
     * @var Db|null
     */
    protected $Db = NULL;

    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var int
     */
    private $accountId = 0;

    /**
     * @var string
     */
    private $sessionId = '';

    /**
     * Enum yes/no
     *
     * @var string
     */
    private $webActive = 'yes';

    /**
     * @var string
     */
    private $remoteAddress = '';

    /**
     * @table accounts
     *
     * @var array
     */
    private $account = [];

    /**
     * @table bans
     *
     * @var array
     */
    private $ban = [];

    /**
     * user constructor.
     */
    private function __construct() {}

    /**
     * @return user|null
     */
    public static function getInstance(): user {

        if (self::$Instance === NULL) {
            self::$Instance = new user();
            self::$Instance->Db = Gserver()->Db();
        }

        return self::$Instance;
    }

    /**
     * @param int $id
     */
    protected function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $accountId
     */
    protected function setAccountId(int $accountId): void {
        $this->accountId = $accountId;
    }

    /**
     * @return int
     */
    public function getAccountId(): int {
        return $this->accountId;
    }

    /**
     * @param string $sessionId
     */
    protected function setSessionId(string $sessionId): void {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getSessionId(): string {
        return $this->sessionId;
    }

    /**
     * @param string $webActive
     */
    protected function setWebActive(string $webActive): void {
        $this->webActive = $webActive;
    }

    /**
     * @return string
     */
    public function getWebActive(): string {
        return $this->webActive;
    }

    /**
     * @param string $remoteAddress
     */
    protected function setRemoteAddress(string $remoteAddress): void {
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @return string
     */
    public function getRemoteAddress(): string {
        return $this->remoteAddress;
    }

    protected function setAccount(): void {

        $property = strtolower(substr(__FUNCTION__,3));

        $Reflection = new \ReflectionClass($this);

        $docComment = $Reflection->getProperty($property)->getDocComment();

        $tablePart = explode("@table ",$docComment)[1];

        $table = trim(substr($tablePart,0,strpos($tablePart,"*")));

        if($this->Db === NULL) {
            $this->Db = Gserver()->Db();
        }

        $this->account = $this->Db->fetchRow("SELECT * FROM " . $table . " WHERE id = ?",
            ['backend', $this->getAccountId()]);

    }

    public function getAccount(): array {
        return $this->account;
    }

    protected function setBan(): void {

        $property = strtolower(substr(__FUNCTION__,3));

        $Reflection = new \ReflectionClass($this);

        $docComment = $Reflection->getProperty($property)->getDocComment();

        $tablePart = explode("@table ",$docComment)[1];

        $table = trim(substr($tablePart,0,strpos($tablePart,"*")));

        if($this->Db === NULL) {
            $this->Db = Gserver()->Db();
        }

        $this->ban = $this->Db->fetchRow("SELECT * FROM " . $table . " WHERE AccountId = ?",
            ['backend', $this->getAccountId()]);

    }

    public function getBan(): array {
        return $this->ban;
    }
}