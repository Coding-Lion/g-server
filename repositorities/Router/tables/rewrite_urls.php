<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 13:13
 */

declare(strict_types=1);

namespace gserver\repositorities\router\tables;


use gserver\repositorities\Table;

/**
 * Table prefix_rewrite_urls
 */
class rewrite_urls extends Table
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var string
     */
    private $link = '';

    /**
     * @var string
     */
    private $intern = '';

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
     * @var int
     */
    private $localeId = 0;

    /**
     * Enum no/yes
     *
     * @var string
     */
    private $active = 'no';

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
     * @param string $link
     */
    protected function setLink(string $link): void {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink(): string {
        return $this->link;
    }

    /**
     * @param string $intern
     */
    protected function setIntern(string $intern): void {
        $this->intern = $intern;
    }

    /**
     * @return string
     */
    public function getIntern(): string {
        return $this->intern;
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
     * @param string $active
     */
    protected function setActive(string $active): void {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getActive(): string {
        return $this->active;
    }
}