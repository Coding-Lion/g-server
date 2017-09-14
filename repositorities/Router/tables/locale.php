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
     * @var int
     */
    private $id = 0;

    /**
     * Enum no/yes
     *
     * @var string
     */
    private $main = 'no';

    /**
     * @var string
     */
    private $iso2 = '';

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