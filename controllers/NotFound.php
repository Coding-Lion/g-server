<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 23:19
 */

declare(strict_types=1);

namespace gserver\controllers;


final class NotFound extends Controller
{

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

        $securityLevel = Gserver()->Session()->getUser()['account']['SecurityLevel'];

        if($securityLevel >= $this->securityLevel) {
            return true;
        }

        return false;

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
}