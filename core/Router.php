<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 29.08.2017
 * Time: 10:43
 */

declare(strict_types=1);

namespace gserver\core;


final class Router
{
    /**
     * @var Router|null
     */
    private static $Instance = NULL;

    /**
     * @var object|null
     */
    protected $Repository = NULL;

    /**
     * @var bool
     */
    protected $redirect = false;

    /**
     * @var string
     */
    protected $locale = '';

    /**
     * @var string
     */
    protected $controller = '';

    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Router constructor.
     */
    private function __construct() {

        $this->Repository = Gserver()->RepositoryManager(['namespace' => 'repositories',
            'repository' => 'Router'])->getRepository();

        $this->Repository->getTable('rewrite_urls')->getDataSet();

        if (!$this->isLinkMapped($_SERVER['REDIRECT_URL'])) {

            $this->setLocale();
            $this->setController();
            $this->setAction();
            $this->params = $_GET;
        }

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return Router
     */
    public static function getInstance() : Router {

        if (self::$Instance === NULL) {
            self::$Instance = new Router();
        }

        return self::$Instance;

    }

    /**
     * Set the language
     */
    private function setLocale(): void {

        $locale = explode('/', $_SERVER['REDIRECT_URL']);

        $oldLocale = array_shift($locale);

        $this->locale = $oldLocale;

        if (!$this->localeExists()) {

            $this->redirect = true;

            $Table = $this->Repository->getTable('locale');
            $Table->setDataSet(['frontend', 'main', 'yes']);

            $this->locale = substr($Table->getDataSet()['iso2'],0,2);
            $location = $_SERVER['SUBDIRECTORY'] . str_replace($oldLocale, $this->locale, $_SERVER['REDIRECT_URL']);

            if(empty($oldLocale) && $location === $_SERVER['SUBDIRECTORY']) {
                $location .= $this->locale;
            }

            if(MODULE === 'backend') {
                $localePath = '/'.$this->locale.'/';
                $location = str_replace($localePath, $localePath.MODULE.'/',$location) . '/backend';
            }

            header('Location: ' . $location);
            exit();

        }

    }

    /**
     * @return string
     */
    public function getLocale(): string {
        return $this->locale;
    }

    /**
     * Includes the controller file and set the class name of the controller
     */
    private function setController(): void {

        $path = __DIR__ . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        $modulePath = MODULE . DIRECTORY_SEPARATOR;
        $parts = explode('/',$_SERVER['REDIRECT_URL']);

        if (MODULE === 'backend') {
            $controller = empty($parts[2]) ? 'index' : $parts[2];
        }
        else {
            $controller = empty($parts[1]) ? 'index' : $parts[1];
        }

        $file = realpath($path . $modulePath . $controller . '.php');

        if ($file) {
            require_once $file;
        }
        else {
            $controller = 'NotFound';
        }

        $this->controller = ucfirst($controller);

    }

    /**
     * @return string
     */
    public function getController(): string {
        return $this->controller;
    }

    /**
     * Set the controller action
     */
    private function setAction(): void {

        $parts = explode('/', $_SERVER['REDIRECT_URL']);

        if (MODULE === 'backend') {
            $this->action = empty($parts[3]) ? 'index' : $parts[3];
        }
        else {
            $this->action = empty($parts[3]) ? 'index' : $parts[3];
        }

    }

    /**
     * @return string
     */
    public function getAction(): string {
        return $this->action;
    }

    /**
     * Set the params property
     *
     * @param array $params
     */
    private function setParams(array $params): void {

        foreach ($params as $key => $param) {
            $parts = explode('=', $param);
            $this->params[$parts[0]] = $parts[1];
        }

    }

    /**
     * @return array
     */
    public function getParams(): array {
        return $this->params;
    }

    /**
     * Check if the requested locale exists
     *
     * @return bool
     */
    private function localeExists(): bool {

        if(!empty($this->locale)) {
            $Table = $this->Repository->getTable('locale');
            $Table->setDataSet(['frontend', 'iso2', $this->locale.'%']);

            if ($Table->getDataSet()['id'] !== 0) {
                return true;
            }
        }

        return false;

    }

    /**
     * Must move
     *
     * Check if the requested uri is linked
     *
     * @return bool
     */
    public function isLinkMapped(): bool {

        $Table = $this->Repository->getTable('rewrite_urls');
        $Table->setDataSet(['frontend', 'link', $_SERVER['REDIRECT_URL']]);

        $dataSet = $Table->getDataSet();

        if ($dataSet['id'] !== 0) {

            $parts = explode('/', $dataSet['intern']);

            $this->locale = $dataSet['iso2'];
            $this->controller = array_shift($parts);
            $this->action = array_shift($parts);

            $params = explode('?', $this->action);

            if (count($params) > 1) {
                $this->setParams(explode('&', $params[1]));
            }

            return true;

        }
        else {
            return false;
        }

    }

    /**
     * @return string
     */
    public function getRootLink(): string {
        return $this->getProtocol() . $_SERVER['SERVER_NAME'] . '/g-server/';
    }

    /**
     * @return string
     */
    public function getMediaLink(): string {
        return $this->getRootLink() . 'media/';
    }

    /**
     * @return string
     */
    private function getProtocol(): string {
        return isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    }

    /**
     * Get all locales
     *
     * @return array
     */
    public function getAllLocale(): array {
        return $this->Repository->getTable('locale')->getAll(['frontend']);
    }

}