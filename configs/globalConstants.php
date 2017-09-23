<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 09:38
 */

const DB_FRONTEND_CONFIG = [
    'host'      => 'localhost',
    'user'      => 'root',
    'password'  => '',
    'dbname'    => 'g-server',
    'prefix'    => 'web_',
    'port'      => 3306,
    'socket'    => 'false',
];

const DB_BACKEND_CONFIG = [
    'host'      => 'localhost',
    'user'      => 'root',
    'password'  => '',
    'dbname'    => 'g-server',
    'prefix'    => '',
    'port'      => 3306,
    'socket'    => 'false',
];

const SECURITY_LEVEL = [
    'Anonymous'     => -1,
    'User'          => 0,
    'Game_Master'   => 1,
    'Developer'     => 2,
    'Administrator' => 3,
];

const NO_PREFIX = 'no_prefix';