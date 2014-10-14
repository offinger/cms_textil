<?php
$this->pageTitle = Yii::app()->name . ' - Resetovanje lozinke ';
$this->breadcrumbs = array(
    'Resetovanje lozinke',
);
?>
<div class="container page-min-height">
    <div class="row" xmlns="http://www.w3.org/1999/html">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/">Početna</a></li>
                <li class="active"><a href="">Povratak izgubljene lozinke</a></li>
            </ol>
        </div>
    </div>
    <div class="page-header">
        <h1>Povratak izgubljene lozinke</h1>
        <strong><?php echo  Yii::t('passwordreset', 'Unesite e-mail koji asocira na Vaš nalog kako bi smo Vam poslali link za promenu lozinke');?></strong>
    </div>
    <div class="horizontal-form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'enableClientValidation' => true,
            //'enableAjaxValidation'=>true,
            'id' => 'email-form',
            'htmlOptions' => array('class' => 'form-horizontal',
                'role' => 'form',
                'id' => 'email-form'
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
            <?php echo $form->labelEx($model, 'email', array('class' => 'col-lg-3 control-label')); ?>
            <div class="col-lg-5">
                <?php echo $form->emailField($model, 'email', array('class' => 'form-control input-lg', 'placeholder' => 'Vaša email adresa')); ?>
                <div class="help-block">
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-6 col-lg-10">
                <?php echo CHtml::submitButton('Pošalji zahtev', array('class' => 'btn btn-primary btn-lg')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>




