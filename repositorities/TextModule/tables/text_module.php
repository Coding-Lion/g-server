<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 14.09.2017
 * Time: 19:56
 */

namespace gserver\repositorities\textmodule\tables;

use gserver\repositorities\Table;

/**
 * Table text_module
 */
class text_module extends Table
{
    /**
     * @var text_module|null
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
     * @var int
     */
    private $localeId = 0;

    /**
     * @var string
     */
    private $namespace = '';

    /**
     * @var string
     */
    private $textNode = '';

    /**
     * @var string
     */
    private $textValue = '';

    /**
     * @var string
     */
    private $areaNode = '';

    /**
     * @var string
     */
    private $areaValue = '';

    /**
     * text_module constructor.
     */
    private function __construct() {
        $this->Db = Gserver()->Db();
    }

    /**
     * @return text_module|null
     */
    public static function getInstance(): text_module {

        if (self::$Instance === NULL) {
            self::$Instance = new text_module();
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
     * @param int $localeId
     */
    protected function setLocaleId(int $localeId): void {
        $this->localeId = $localeId;
    }

    /**
     * @return int
     */
    public function getLocaleId(): int {
        return $this->localeId;
    }

    /**
     * @param string $namespace
     */
    protected function setNamespace(string $namespace): void {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace(): string {
        return $this->namespace;
    }

    /**
     * @param string $textNode
     */
    protected function setTextNode(string $textNode): void {
        $this->textNode = $textNode;
    }

    /**
     * @return string
     */
    public function getTextNode(): string {
        return $this->textNode;
    }

    /**
     * @param string $textValue
     */
    protected function setTextValue(string $textValue): void {
        $this->textValue = $textValue;
    }

    /**
     * @return string
     */
    public function getTextValue(): string {
        return $this->textValue;
    }

    /**
     * @param string $areaNode
     */
    protected function setAreaNode(string $areaNode): void {
        $this->areaNode = $areaNode;
    }

    /**
     * @return string
     */
    public function getAreaNode(): string {
        return $this->areaNode;
    }

    /**
     * @param string $areaValue
     */
    protected function setAreaValue(string $areaValue): void {
        $this->areaValue = $areaValue;
    }

    /**
     * @return string
     */
    public function getAreaValue(): string {
        return $this->areaValue;
    }

}