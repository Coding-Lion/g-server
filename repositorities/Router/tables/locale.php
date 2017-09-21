<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 22:41
 */

namespace gserver\repositorities\router\tables;


use gserver\repositorities\Table;

/**
 * Table prefix_locale
 */
class locale extends Table
{
    /**
     * @var rewrite_urls|null
     */
    private static $Instance = NULL;

    /**
     * @var Db|null
     */
    private $Db = NULL;

    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $iso2 = '';

    /**
     * Enum no/yes
     *
     * @var string
     */
    private $main = 'no';

    /**
     * locale constructor.
     */
    private function __construct() {
        $this->Db = Gserver()->Db();
    }

    /**
     * @return locale|null
     */
    public static function getInstance(): locale
    {
        if (self::$Instance === NULL) {
            self::$Instance = new locale();
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
     * @param string $name
     */
    protected function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $iso2
     */
    protected function setIso2(string $iso2): void {
        $this->iso2 = $iso2;
    }

    /**
     * @return string
     */
    public function getIso2(): string {
        return $this->iso2;
    }

    /**
     * @param string $main
     */
    protected function setMain(string $main): void {
        $this->main = $main;
    }

    /**
     * @return string
     */
    public function getMain(): string {
        return $this->main;
    }
}