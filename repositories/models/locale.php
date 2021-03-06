<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 22:41
 */

declare(strict_types=1);

namespace gserver\repositories\models;


/**
 * Table prefix_locale
 */
class locale extends Model
{
    /**
     * @var rewrite_urls|null
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
     * @var string
     */
    private $name_de = '';

    /**
     * @var string
     */
    private $name_en = '';

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
    private function __construct() {}

    /**
     * @return locale|null
     */
    public static function getInstance(): locale {

        if (self::$Instance === NULL) {
            self::$Instance = new locale();
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
     * @param string $name
     */
    protected function setName_de(string $name): void {
        $this->name_de = $name;
    }

    /**
     * @return string
     */
    public function getName_de(): string {
        return $this->name_de;
    }

    /**
     * @param string $name
     */
    protected function setName_en(string $name): void {
        $this->name_en = $name;
    }

    /**
     * @return string
     */
    public function getName_en(): string {
        return $this->name_en;
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