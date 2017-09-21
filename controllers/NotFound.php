<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 02.09.2017
 * Time: 23:19
 */

namespace gserver\controllers;


use gserver\controllers\Controller;

final class NotFound extends Controller
{
    public function indexAction(): bool {
        return true;
    }
}