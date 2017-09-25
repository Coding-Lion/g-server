<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 02:01
 */

namespace gserver\controllers\backend;

use gserver\controllers\Controller;

class Auth extends Controller
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
        return "Auth";
    }

    /**
     * @return bool
     */
    public function preDispatch(): bool {

        $securityLevel = Gserver()->Session()->getUser()['account']['SecurityLevel'];

        if($securityLevel >= $this->securityLevel) {
            return true;
        }

        return true;

    }

}