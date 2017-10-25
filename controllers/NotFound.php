<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 23:19
 */

declare(strict_types=1);

namespace gserver\controllers;


final class NotFound
{
    /**
     * @var bool
     */
    protected $rendering = true;

    /**
     * @return string
     */
    public function getClass(): string {
        return __CLASS__;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "NotFound";
    }

    /**
     * @return bool
     */
    public function preDispatch(): bool {
        return true;
    }

    /**
     * @return bool
     */
    public function indexAction(): bool {
        return true;
    }

    /**
     * @return bool
     */
    public function forbiddenAction(): bool {
        return true;
    }

    /**
     * @param $toInclude
     */
    public function loadTemplate(array $toInclude): void {

        if ($this->rendering) {

            foreach($toInclude as $file) {
                require_once $file;
            }

        }

    }
}