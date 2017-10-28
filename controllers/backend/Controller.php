<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 27.09.2017
 * Time: 13:37
 */

namespace gserver\controllers\backend;


abstract class Controller
{
    /**
     * @var int
     */
    protected $securityLevel = 1;

    /**
     * @var bool
     */
    protected $rendering = true;

    /**
     * @var bool
     */
    protected $redirect = false;

    /**
     * @return string
     */
    abstract function getName(): string;

    /**
     * @return mixed
     */
    abstract function getClass(): string;

    /**
     * @return bool
     */
    abstract function preDispatch(): bool;

    /**
     * @param $toInclude
     */
    public function loadTemplate($toInclude): void {

        if ($this->rendering) {

            foreach($toInclude as $file) {
                require_once $file;
            }

        }

    }
}