<?php
/**
 * fCMS
 * BaseController.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */

class BaseController extends CController {

    private $_behaviorIDs = array();

    public function init() {
        parent::init();
    }

    /**
     * @var Postavlja defaultni layout u nekom kontroleru: '//layouts/column1',
     * Vidi: 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/col2';

    /**
     * @var niz sa stavkama za navigacioni meni. Pogledaj: {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var niz za breadcrumbs-e za neku od stranica. Vrednost ove metode
     * bice dodeljena {@link CBreadcrumbs::links}. Refrentni objekat je{@link CBreadcrumbs::links}
     * za vise detalja oko prilagodjavanja
     */
    public $breadcrumbs = array();

    public function createAction($actionID) {
        $action = parent::createAction($actionID);
        if ($action !== null)
            return $action;
        foreach ($this->_behaviorIDs as $behaviorID) {
            $object = $this->asa($behaviorID);
            if ($object->getEnabled() && method_exists($object, 'action' . $actionID))
                return new CInlineAction($object, $actionID);
        }
    }

    public function attachBehavior($name, $behavior) {
        $this->_behaviorIDs[] = $name;
        parent::attachBehavior($name, $behavior);
    }


}