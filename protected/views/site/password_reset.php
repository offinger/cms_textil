<?php
$this->pageTitle = Yii::app()->name . ' - Resetovanje lozinke';
$this->breadcrumbs = array(
    'Resetovanje lozinke',
);
?>
<div class="container page-min-height">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/">Početna</a></li>
                <li class="active"><a href="">Resetovanje lozinke</a></li>
            </ol>
        </div>
    </div>
    <div class="page-header">
        <h1>Resetovanje lozinke</h1>
        <strong> <?php echo  Yii::t('passwordreset', 'Upišite Vašu novu lozinku');?> </strong>
    </div>
    <div class="horizontal-form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableClientValidation' => true,
            //'enableAjaxValidation'=>true,
            'id' => 'password-form',
            'htmlOptions' => array('class' => 'form-horizontal',
                'role' => 'form',
                'id' => 'password-form',
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'errorCssClass' => 'has-error',
                'successCssClass' => 'has-success',
                'inputContainer' => '.form-group',
                'validateOnChange' => true
            ),
        )); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'password', array('class' => 'col-lg-3 control-label')); ?>
            <div class="col-lg-5">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg', 'placeholder' => 'Vaša nova lozinka')); ?>
                <div class="help-block">
                    <?php echo $form->error($model, 'password'); ?>
                </div>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'key', array('value' => $key));?>
        <?php echo $form->hiddenField($model, 'email', array('value' => $email));?>
        <div class="form-group">
            <div class="col-lg-offset-6 col-lg-10">
                <?php echo CHtml::submitButton('Pošalji zahtev', array('class' => 'btn btn-primary btn-lg')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>