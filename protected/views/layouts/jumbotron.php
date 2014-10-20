<?php $this->beginContent('/layouts/main'); ?>
            <?php $start_time = microtime(true); ?>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Paleta <b>CMS</b></a>
            </div>
            <div class="navbar-collapse collapse">
                <?php 

                $menuLoggedBrend = array();
                $menuLoggedProizvod = array();
                $menuLoggedModel = array();
                $menuLoggedKolekcija = array();
                if(!Yii::app()->user->isGuest) {
                    $menuLoggedProizvod =  array('label' => 'Proizvodi', 'url' => array('#'), 'itemOptions' => array('class' => 'dropdown'),
                            'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                            'submenuOptions' => array('class' => 'dropdown-menu'),
                            'items' => array(
                                array('label' => 'Lista svih proizvoda', 'url' => array('proizvodi/admin')),
                                array('label' => 'Unesi nov proizvod', 'url' => array('proizvodi/create')),
                            )
                    );

                    $menuLoggedBrend =  array('label' => 'Brendovi', 'url' => array('#'), 'itemOptions' => array('class' => 'dropdown'),
                            'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                            'submenuOptions' => array('class' => 'dropdown-menu'),
                            'items' => array(
                                array('label' => 'Lista svih brendova', 'url' => array('brendovi/admin')),
                                array('label' => 'Unesi nov brend', 'url' => array('brendovi/create')),
                            )
                    );

                    $menuLoggedKolekcija =  array('label' => 'Kolekcije', 'url' => array('#'), 'itemOptions' => array('class' => 'dropdown'),
                            'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                            'submenuOptions' => array('class' => 'dropdown-menu'),
                            'items' => array(
                                array('label' => 'Lista svih kolekcija', 'url' => array('kolekcije/admin')),
                                array('label' => 'Unesi novu kolekciju', 'url' => array('kolekcije/create')),
                            )
                    );
                    
                    $menuLoggedModel =  array('label' => 'Modeli', 'url' => array('#'), 'itemOptions' => array('class' => 'dropdown'),
                            'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                            'submenuOptions' => array('class' => 'dropdown-menu'),
                            'items' => array(
                                array('label' => 'Lista svih modela', 'url' => array('modeli/admin')),
                                array('label' => 'Unesi nov model', 'url' => array('modeli/create')),
                            )
                    );
                }


                $this->widget('zii.widgets.CMenu', array(
                    'encodeLabel' => true,
                    'items' => array(
                        array('label' => 'Početna', 'url' => array('/site/index')),
                        $menuLoggedProizvod,
                        // $menuLoggedBrend,
                        // $menuLoggedKolekcija,
                        $menuLoggedModel,

                    ),
                    // 'htmlOptions'=>array('class'=>'main-menu')
                    'htmlOptions' => array('class' => 'nav navbar-nav')
                    
                )); 
                ?>
                <?php if (app()->user->isGuest): ?>
                    <?php
                    $model = new LoginForm();
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'nav-bar_login-form',
                        'enableClientValidation' => true,
                        'action' => $this->createUrl('site/login'),
                        //'enableAjaxValidation'=>true,
                        'errorMessageCssClass' => 'has-error',
                        'htmlOptions' => array(
                            'id' => 'login-form',
                            'class' => 'navbar-form navbar-right',
                            'role' => 'form',
                        ),
                        'clientOptions' => array(
                            'id' => 'nav-bar_login-form',
                            'validateOnSubmit' => true,
                            'errorCssClass' => 'has-error',
                            'successCssClass' => 'has-success',
                            'inputContainer' => '.form-group',
                            'validateOnChange' => true
                        ),
                    ));
                    ?>
                    <form>
                        <div class="form-group">
                            <?php echo $form->textField($model, 'username', array('max-length' => '10', 'class' => 'form-control', 'placeholder' => 'Korisničko ime')); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->passwordField($model, 'password', array('max-length' => '10', 'class' => 'form-control', 'type' => 'password', 'placeholder' => 'Lozinka')); ?>
                        </div>

                        <?php echo CHtml::submitButton('Prijava', array('class' => 'btn btn-primary btn-sm')); ?>

                        <?php $this->endWidget(); ?>
                    </form>

                <?php else: ?>
                    <div class=" navbar-right">
                        <span class="navbar-brand"><small>Zdravo,<?php echo app()->user->name; ?></small></span>
                            <span class="navbar-brand">
                                <a class="navbar-right" href="<?php echo $this->createUrl('site/logout') ?>">
                                <button type="button" style="height:20px; font-size:10px;" class="btn btn-sm btn-danger">Odjava</button>
                                </a></span>
                    </div>
                <?php endif;?>
            </div>
            <!--/.navbar-collapse -->
        </div>
        <!--/.container -->
    </div><!--/.navbar -->
    <div class="container">
        <?php
        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) :?>
            <?php foreach ($flashMessages as $key => $message)  : ?>
                <div class="alert alert-dismissable alert-<?php echo $key; ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong><?php echo   $message;?></strong>
                </div>
            <?php endforeach; ?>
        <?php endif;?>
        <?php echo $content; ?>
        <hr>
        <footer>
            <p style="width:500px; float:left;">&copy; Paleta , <?php echo date('Y'); ?> // Pokreće: <b style='color:blue;'>fmtrx</b>
            <span style='color:gray; font-size:11px;'>Strana generisana u: <?php echo(number_format(microtime(true) - $start_time, 2)); ?> sekundi.</span>
            </p>
            <img style="float:right;" src="/control/img/made_on_mac.png"> </img>
        </footer>
    </div> <!-- /container -->
<?php $this->endContent(); ?>
<?php cs()->registerCssFile($this->getBootstrap3LayoutCssFileURL()); ?>