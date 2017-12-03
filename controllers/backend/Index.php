<?php
/**
 * Created by PhpStorm.
 * User: Saito88
 * Date: 21.09.2017
 * Time: 02:02
 */

namespace gserver\controllers\backend;


use gserver\core\Gserver;

class Index extends Controller
{
    /**
     * @var array
     */
    public $windows = [];

    /**
     * Index constructor.
     */
    public function __construct() {
        $this->redirect = true;
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
        return "Index";
    }

    /**
     * @return bool
     */
    public function preDispatch(): bool {

        $securityLevel = Gserver()->Session()->getUser()['account']['SecurityLevel'];

        if ($securityLevel >= $this->securityLevel) {
            return true;
        }

        if ($this->redirect) {
            $Router = Gserver()->Router();
            header('Location: ' . $Router->getRootLink() . $Router->getLocale() . '/' . MODULE .
                '/auth');
            exit();
        }

    }

    public function indexAction(): bool {

        $Db = Gserver()->Db();

        $languages = $Db->fetchAll("SELECT * FROM locale",'frontend');
        $this->windows['languages']['table'] = 'web_locale';
        $this->windows['languages']['all'] = $languages;
        $this->windows['languages']['count'] = count($languages);

        $seo = $Db->fetchAll("SELECT * FROM rewrite_urls",'frontend');
        $this->windows['seo']['table'] = 'web_rewrite_urls';
        $this->windows['seo']['all'] = $seo;
        $this->windows['seo']['count'] = count($seo);

        $translations = $Db->fetchAll("SELECT * FROM text_module",'frontend');
        $this->windows['translations']['table'] = 'web_text_module';
        $this->windows['translations']['all'] = $translations;
        $this->windows['translations']['count'] = count($translations);

        $user = $Db->fetchAll("SELECT * FROM user",'frontend');
        $this->windows['user']['table'] = 'web_user';
        $this->windows['user']['all'] = $user;
        $this->windows['user']['count'] = count($user);

        return true;
    }

    public function getLocalesAction() {

        $this->rendering = false;

        $Db = Gserver()->Db();

        $languages = $Db->fetchAll("SELECT * FROM locale",'frontend');

        die(json_encode(array_values($languages)));

    }

    public function getTranslationsAction() {

        $this->rendering = false;

        $Db = Gserver()->Db();

        $translations = [];

        $result = $Db->fetchAll("SELECT a.id,name_de,name_en,namespace,textNode,textValue,areaNode,areaValue FROM text_module a LEFT JOIN web_locale b ON a.localeId=b.id LIMIT 0,10",'frontend');
        $translations['data'] = array_values($result);
        $translations['totalCount'] = $Db->fetchOne("SELECT COUNT(id) FROM text_module",'frontend');
        die(json_encode($translations));

    }

}