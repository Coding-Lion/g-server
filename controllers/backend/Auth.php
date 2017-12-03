<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 02:01
 */

namespace gserver\controllers\backend;


use gserver\core\Gserver;

class Auth extends Controller
{

    /**
     * Index constructor.
     */
    public function __construct() {
        $this->securityLevel = SECURITY_LEVEL['Anonymous'];
    }

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

    public function indexAction(): bool {
        return true;
    }

    public function loginAction(): string {

        $this->rendering = false;

        $username = $_POST['username'];
        $passwd = $_POST['password'];

        $Db = Gserver()->Db();

        $result = $Db->fetchRow("SELECT Id,Password,SecurityLevel FROM accounts WHERE Username = ?", $username);

        if(empty($result) || $result['SecurityLevel'] < SECURITY_LEVEL['Game_Master']) {
            die('false');
        }

        $Hashing = Gserver()->Hashing(['namespace' => 'components']);

        if($Hashing->checkHash($passwd,$result['Password'])) {
            $Db->query("UPDATE user SET sessionId = ? WHERE accountId = ?",['frontend', session_id(), $result['Id']]);
            die('true');
        } else {
            die('false');
        }

    }

    public function logoutAction(): string {

        $this->rendering = false;

        $Db = Gserver()->Db();

        $Db->query("UPDATE user SET sessionId = '' WHERE sessionId = ?", ['frontend', session_id()]);

        header('Location:' . Gserver()->Router()->getRootLink().'backend');
        exit();

    }
}