<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 06.08.2017
 * Time: 21:16
 */

declare(strict_types=1);

namespace gserver\core;


use gserver\controllers\NotFound;

final class Request
{

    /**
     * @var Request|null
     */
    private static $Instance = NULL;

    /**
     * @var string
     */
    protected $module = '';

    /**
     * @var object|null
     */
    protected $Controller = NULL;

    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var array
     */
    protected $allowedParams = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $toInclude = [];

    /**
     * Request constructor.
     */
    private function __construct() {
        $this->setRequest();
        $this->validatePostAndGet();
    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the instance and return it
     *
     * @return Request
     */
    public static function getInstance() : Request {

        if (self::$Instance === NULL) {
            $Request = new Request();
            self::$Instance = $Request;
        }

        return self::$Instance;

    }

    /**
     * Sets all Request parameters and initiate the instance of the controller
     */
    private function setRequest(): void {

        $Router = Gserver()->Router();

        $this->module = $Router->getModule();

        // Sets the database connection
        Gserver()->Db($this->module);

        $controller = $Router->getController();
        $action = $Router->getAction();

        $this->allowedParams = CONTROLLER_PARAMETER[$controller];

        if (empty($this->allowedParams)) {
            // Failure
        }

        $this->Controller = new $controller();
        $this->action = $action;
        $this->params = $Router->getParams();

        if(!in_array($action . 'Action', get_class_methods($controller))) {

            require_once('..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'NotFound.php');
            $this->Controller = new NotFound();
            $this->action = 'indexAction';

        }

    }

    /**
     * Parse and filter all given parameters from $this->params and $_POST
     */
    private function validatePostAndGet(): void {

        $globals = array_merge($this->params,$_POST);

        $params = [];

        foreach ($globals as $key => $value) {
            // TODO: build Validations
            $params[$key] = $value;
        }

        $this->params = $params;

    }

    /**
     * Dispatch the controller action or load and dispatch the NotFound controller
     */
    public function dispatchController(): void {

        $action = $this->action . 'Action';
        $result = $this->Controller->$action($this->params);

        if ($result === false) {

            require_once('..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'NotFound.php');
            $this->Controller = new NotFound();
            $this->Controller->indexAction();

        }

        $this->setToInclude();

    }

    /**
     * Set all files were required to include
     */
    private function setToInclude(): void {

        $basepath = '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR;

        $header = $basepath . 'header.php';
        $footer = $basepath . 'footer.php';

        $controllerPath = $basepath . strtolower($this->Controller->getName()) . DIRECTORY_SEPARATOR;
        $file = $controllerPath . $this->action . '.php';

        $this->toInclude = [$header,$file,$footer];

    }

     public function getParams(): array {
        return $this->params;
     }

    /**
     * @return object
     */
    public function getController(): object {
        return $this->Controller;
    }
}
