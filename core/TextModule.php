<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 03.09.2017
 * Time: 03:45
 */

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

    public $textblocks = [];


    private $controller = '';

    /**
     * TextModule constructor.
     */
    private function __construct() {}

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
            $TextModule = new TextModule();

            $Reflection = new \ReflectionClass($TextModule);

            $TextModule->Repository = Gserver()->RepositoryManager(
                ['namespace' => 'repositorities',
                    'repositority' => $Reflection->getShortName()]
            )->getRepository();

            $TextModule->loadRequestedTextBlocks();

            self::$Instance = $TextModule;
        }

        return self::$Instance;

    }

    private function loadRequestedTextBlocks(): void {

        $Table = $this->Repository->getTable('text_module');

        $Router = Gserver()->Router();

        $Request = Gserver()->Request();

        $this->controller = $Request->getController()->getName();
        $action = $Request->getAction();

        $namespace = $Router->getLocale().'/'.$Router->getModule().'/'.$this->controller.'/'.$action;

        $blocks = $Table->getAll(['namespace' => $namespace]);

        $this->setBlocks($blocks);

        $blocks = $Table->getAll(['namespace' => $Router->getLocale().'/global']);

        $this->setBlocks($blocks);
    }

    private function setBlocks(array $blocks): void {

        if (!empty($blocks)) {

            $namespace = $blocks[0]['namespace'] === "de/global" ? "global" : $this->controller;

            foreach($blocks as $block) {

                $key = !empty($block['textNode']) ? $block['textNode'] : $block['areaNode'];
                $value = !empty($block['textValue']) ? $block['textValue'] : $block['areaValue'];

                $this->textblocks[$namespace][$key] = $value;

            }

        }

    }
}