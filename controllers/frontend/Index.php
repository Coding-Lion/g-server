<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 03.09.2017
 * Time: 03:17
 */

namespace gserver\controllers\frontend;


use gserver\controllers\Controller;

final class Index extends Controller
{

    /**
     * @return string
     */
    public function getName(): string {
        return "Index";
    }

    /**
     * @return string
     */
    public function getClass(): string {
        return __CLASS__;
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

    /**
     * @return bool
     */
    public function indexAction(): bool {
        return true;
    }
}