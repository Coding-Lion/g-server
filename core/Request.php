<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 06.08.2017
 * Time: 21:16
 */

declare(strict_types=1);

namespace gserver\core;


final class Request
{
    /**
     * @var Request|null
     */
    private static $Instance = NULL;

    /**
     * @var object|null
     */
    protected $Controller = NULL;

    /**
     * @var string
     */
    protected $action = 'index';

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
            self::$Instance = new Request();
        }

        return self::$Instance;

    }

    /**
     * Sets all Request parameters and initiate the instance of the controller
     */
    private function setRequest(): void {

        $controllersPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers');
        require_once $controllersPath . DIRECTORY_SEPARATOR . MODULE . DIRECTORY_SEPARATOR . 'Controller.php';
        require_once $controllersPath . DIRECTORY_SEPARATOR . 'NotFound.php';

        $controllerNamespace = '\\gserver\\controllers\\';
        $namespace = $controllerNamespace . MODULE . '\\';
        $defaultClass = $controllerNamespace . MODULE . '\\Index';

        if (empty($_SERVER['REDIRECT_URL']) || MODULE === $_SERVER['REDIRECT_URL']) {
            require_once $controllersPath . DIRECTORY_SEPARATOR . MODULE . DIRECTORY_SEPARATOR . 'Index.php';
            $this->Controller = new $defaultClass();
        }
        else {

            $Router = Gserver()->Router();

            $controller = $Router->getController();
            $controller === 'NotFound' ?
                $controller = $controllerNamespace . $controller :
                $controller = $namespace . $controller;

            $this->Controller = new $controller();

            if(!in_array($this->action . 'Action', get_class_methods($controller))) {
                $controller = $controllerNamespace . 'NotFound';
                $this->Controller = new $controller;
            }
            else {

                $this->action = $Router->getAction();
                $this->params = $Router->getParams();
                $this->validatePostAndGet();

            }

        }

        $this->dispatchController();

    }

    /**
     * Parse and filter all given parameters from $this->params and $_POST
     */
    private function validatePostAndGet(): void {

        $globals = array_merge($this->params, $_POST);

        $params = [];

        foreach ($globals as $key => $value) {
            // TODO: build Validations
            $params[$key] = $value;
        }

        $this->params = $params;

    }

    /**
     * Dispatch the controller action
     */
    public function dispatchController(): void {

        $action = $this->action . 'Action';

        $securityCheck = $this->Controller->preDispatch();

        if ($securityCheck === false) {
            $this->Controller = new NotFound();
            $action = 'forbiddenAction';
        }

        $this->Controller->$action($this->params);
        $this->setToInclude();

    }

    /**
     * Set required files for output
     */
    private function setToInclude(): void {

        $basePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR .
            MODULE . DIRECTORY_SEPARATOR;

        $header = realpath($basePath . 'header.php');
        $footer = realpath($basePath . 'footer.php');

        if($this->Controller->getName() === 'NotFound') {
            $basePath = str_replace(DIRECTORY_SEPARATOR.MODULE, '',$basePath);
        }

        $controllerPath = $basePath . strtolower($this->Controller->getName()) . DIRECTORY_SEPARATOR;
        $file = realpath($controllerPath . $this->action . '.php');

        if($file === false) {
            throw new \Exception('file not found '.realpath($controllerPath).DIRECTORY_SEPARATOR.$this->action.'.php');
        }

        $this->toInclude = [$header,$file,$footer];

    }

    /**
     * @return array
     */
    public function getToInclude(): array {
        return $this->toInclude;
    }

    /**
     * @return array
     */
     public function getParams(): array {
        return $this->params;
     }

    /**
     * @return Instance of the called controller class
     */
    public function getController() {
        return $this->Controller;
    }

    /**
     * @return string
     */
    public function getAction(): string {
        return $this->action;
    }
}
