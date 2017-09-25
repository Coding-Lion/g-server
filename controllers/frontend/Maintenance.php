<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 01:48
 */

namespace gserver\controllers\frontend;

use gserver\controllers\Controller;

final class Maintenance extends Controller
{

    public function getClass(): string {
        return __CLASS__;
    }

    public function getName(): string {
        return "Maintenance";
    }

    public function preDispatch(): bool {

        $securityLevel = Gserver()->Session()->getUser()['account']['SecurityLevel'];

        if($securityLevel >= $this->securityLevel) {
            return true;
        }

        return true;

    }

    public function indexAction(): bool {
        return true;
    }
}