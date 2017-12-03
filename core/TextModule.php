<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 03.09.2017
 * Time: 03:45
 */

declare(strict_types=1);

namespace gserver\core;


final class TextModule
{
    /**
     * @var TextModule|null
     */
    private static $Instance = NULL;

    /**
     * @var object|null
     */
    protected $Repository = NULL;

    /**
     * @var string
     */
    public $locale = '';

    /**
     * @var array
     */
    public $textBlocks = [];

    /**
     * @var string
     */
    private $controller = '';

    /**
     * TextModule constructor.
     */
    private function __construct() {

        $this->Repository = Gserver()->RepositoryManager(['namespace' => 'repositories',
                'repository' => 'TextModule'])->getRepository();

        $Table = $this->Repository->getTable('text_module');

        $Router = Gserver()->Router();
        $Request = Gserver()->Request();

        $this->locale = $Router->getLocale();

        $this->controller = $Request->getController()->getName();
        $action = $Request->getAction();

        $namespace = $this->locale . '/' . MODULE . '/' . $this->controller . '/' . $action;

        $blocks = $Table->getAll(['frontend', 'namespace' => $namespace]);

        $this->setBlocks($blocks);

        $blocks = $Table->getAll(['frontend', 'namespace' => $this->locale .'/global']);

        $this->setBlocks($blocks);

    }

    /**
     * Singleton pattern don't allow clone
     */
    private function __clone() {}

    /**
     * Initiate the Instance and return it
     *
     * @return TextModule
     */
    public static function getInstance(): TextModule {

        if (self::$Instance === NULL) {
            self::$Instance = new TextModule();
        }

        return self::$Instance;

    }

    /**
     * @param array $blocks
     */
    private function setBlocks(array $blocks): void {

        if (!empty($blocks)) {

            $namespace = $blocks[0]['namespace'] === $this->locale . '/global' ? 'global' : $this->controller;

            foreach($blocks as $block) {

                $key = !empty($block['textNode']) ? $block['textNode'] : $block['areaNode'];
                $value = !empty($block['textValue']) ? $block['textValue'] : $block['areaValue'];

                $this->textBlocks[$namespace][$key] = $value;

            }

        }

    }
}