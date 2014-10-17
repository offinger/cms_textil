<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'CMS',
    'layout' => 'jumbotron',
    'preload' => array(
        'log',
        'input',
        'bootstrap',
    ),

    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.bootstrap.components.*',
        'application.extensions.bootstrap.helpers.TbHtml',
        'application.vendors.FirePHPCore.FirePHP',
        'application.vendors.FirePHPCore.FB',
    ),
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . DS.'..'.DS.'extensions'.DS.'bootstrap'),
        'yiiwheels' => 'webroot.protected.extensions.yiiwheels'
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
            'ipFilters' => array('127.0.0.1', '::1'),
        ),

    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
        ),
        //email
        'mailer' => array(
            'class' => 'application.extensions.mailer.EMailer',
        ),

        'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            'driver'=>'GD',
            'params'=>array( 'directory'=>'/opt/local/bin' ),
        ),

        //filter,security
        'input' => array(
            'class' => 'CmsInput',
            'cleanPost' => true,
            'cleanGet' => true,
            'cleanMethod' => 'stripClean'
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.KTbApi',
        ),
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'site/page/<view:\w+>' => 'site/page/',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),

        /*'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),*/

        /*'db' => (!APP_DEPLOYED) ?
            array( //LOCALHOST
                'class' => 'CDbConnection',
                'connectionString' => 'mysql:host=mysql;dbname=tgroupco_satovi',
                'username' => 'tgroupco_satovi',
                'password' => 's4t0v1',
                'charset' => 'UTF8',
                'tablePrefix' => '', // even empty table prefix required!!!
                'emulatePrepare' => true,
                'enableProfiling' => true,
                'schemaCacheID' => 'cache',
                'queryCacheID' => 'cache',
                'schemaCachingDuration' => 120
            ):
        array(       //SERVER
            'class' => 'CDbConnection',
                              'connectionString' => 'mysql:host=mysql;dbname=tgroupco_satovi',
                                'username' => 'tgroupco_satovi',
                		'password' => 's4t0v1',
                               'charset' => 'UTF8',
                               'tablePrefix' => '',
                               'emulatePrepare' => true,
                               //   'enableProfiling' => true,
                              'schemaCacheID' => 'cache',
                             'schemaCachingDuration' => 3600
                                              ),*/

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=cms',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),


        'errorHandler' => array(
            'errorAction' => 'site/error',
),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
        /*
        array(
            'class'=>'CWebLogRoute',
        ),
        */
    ),
),
        'clientScript' => array(
    'class' => 'CClientScript',
    'scriptMap' => array(
        'jquery.js' => false,
        //'jquery.min.js' => false
    ),
    'coreScriptPosition' => CClientScript::POS_END,
),
    ),

    'params' => array(
        'fromEmail' => 'offinger@gmail.com',
        'replyEmail' => 'offinger@gmail.com',
        'myEmail' => 'offinger@gmail.com',
        'gmail_password' => '',
        'recaptcha_private_key' => '', // captcha nece raditi bez api kjuc-a
        'recaptcha_public_key' => '', //http://www.google.com/recaptcha
        'contactRequireCaptcha' => true,
        'bootswatch2_skin' => 'none',
        'bootswatch3_skin' => 'spacelab',
        'render_switch_form' => false,
    ),
);