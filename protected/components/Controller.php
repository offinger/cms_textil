<?php
/**
 * fCMS
 * Controller.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class Controller extends CController {

    public function  init(){
        if (app()->params->render_switch_form) {
            $this->getLayoutAndBootswatchSkinFromSession();
            $this->handleSwitchForm();
        }
        $this->registerJs();
        $this->registerCss();
        //Ukoliko tema nije izabrana u config/main,bootstrap3 asset/i su registrovani.
        //ukoliko je tema bootstrap2,bootstrap assets-i su registrovani od strane yiistrap-a u themes/bootstrap2/layouts/main.php
        if (!app()->theme)
            $this->registerBootstrap3CoreAssets();
    }

    public function getLayoutAndBootswatchSkinFromSession() {
        if (!isset($_POST['layout'])) {
            if (isset(app()->session['layout']))
                app()->layout = app()->session['layout'];
            if (isset(app()->session['bootswatch3_skin']))
                app()->params->bootswatch3_skin = app()->session['bootswatch3_skin'];
        }
    }

    public function handleSwitchForm() {

        if (isset($_POST['layout'])) {
            app()->layout = $_POST['layout'];
            app()->params->bootswatch3_skin = $_POST['bootswatch_skin'];
            app()->session['layout'] = app()->layout;
            app()->session['bootswatch3_skin'] = app()->params->bootswatch3_skin;
        }
    }


    public function registerJs() {
        cs()->registerScriptFile(bu() . '/libs/jquery/jquery.min.js', CClientScript::POS_BEGIN);
        cs()->registerScriptFile(bu() . '/js/plugins.js', CClientScript::POS_END);
        cs()->registerScriptFile(bu() . '/js/main.js', CClientScript::POS_END);
    }
    public function registerCss(){
        cs()->registerCssFile(bu() . '/css/main.css');
    }


    public function getBootstrap3LayoutCssFileURL() {
        return bu() . '/libs/bootstrap/examples/' . app()->layout . '/' . app()->layout . '.css';
    }

    public function getBootstrap2LayoutCssFileURL() {
        return bu() . '/yiistrap_assets/layouts/' . app()->layout . '.css';
    }

    public function registerBootstrap3CoreAssets() {

        //bootstrap css
        (app()->params['bootswatch3_skin'] == "none") ?
            cs()->registerCssFile(bu() . '/libs/bootstrap/dist/css/bootstrap.min.css') :
            cs()->registerCssFile(bu() . '/libs/bootswatch/' . app()->params['bootswatch3_skin'] . '/bootstrap.min.css');

        //bootstrap js
        cs()->registerScriptFile(bu() . '/libs/bootstrap/dist/js/bootstrap.min.js', CClientScript::POS_END);
    }

    public $menu = array();
    public $breadcrumbs = array();
}