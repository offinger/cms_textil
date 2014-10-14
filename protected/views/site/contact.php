<?php
$this->pageTitle = Yii::app()->name . ' - Kontakt';
$this->breadcrumbs = array(
    'Kontakt',
);
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="/">Početna</a></li>
                <li class="active"><a href="">Kontakt</a></li>
            </ol>
        </div>
    </div>
    <?php if (Yii::app()->user->hasFlash('contact')): ?>
        <div class="alert alert-info  alert-dismissable">
            <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
            <strong><?php echo Yii::app()->user->getFlash('contact'); ?>rttrt</strong>
        </div>
    <?php else: ?>
        <div class="page-header">
            <h1>Contact </h1>
        </div>
        <div class="horizontal-form">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'enableClientValidation' => true,
                //'enableAjaxValidation'=>true,
                // 'errorMessageCssClass'=>'has-error',

                'htmlOptions' => array('class' => 'form-horizontal',
                    'role' => 'form',
                    'id' => 'contact-form'
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
                <div class="col-lg-3 control-label">
                    <div>
                        <p class="note">Polja sa <span class="required">*</span> su obavezna.</p>
                    </div>
                </div>

                <div class="col-lg-5  has-error">
                    <div class="help-block ">
                        <?php echo $form->errorSummary($model); ?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-5">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Ime')); ?>
                    <div class="help-block">
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'email', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-5">
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                    <span class="help-block help-inline ">
                <?php echo $form->error($model, 'email'); ?>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'subject', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-5">
                    <?php echo $form->textField($model, 'subject', array('class' => 'form-control', 'placeholder' => 'Naslov')); ?>
                    <div class="help-block">
                        <?php echo $form->error($model, 'subject'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'body', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-5">
                    <?php echo $form->textArea($model, 'body', array('class' => 'form-control', 'placeholder' => 'Poruka', 'rows' => 6, 'cols' => 50)); ?>
                    <div class="help-block">
                        <?php echo $form->error($model, 'body'); ?>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-10">
                    <?php if ($model->getRequireCaptcha()) : ?>
                        <?php $this->widget('application.extensions.recaptcha.EReCaptcha',
                            array('model' => $model, 'attribute' => 'verify_code',
                                'theme' => 'red', 'language' => 'en',
                                'publicKey' => Yii::app()->params['recaptcha_public_key']));?>
                        <?php echo CHtml::error($model, 'verify_code'); ?>
                    <?php endif; ?>
                </div>
            </div>


            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-10">
                    <?php echo CHtml::submitButton('Posalji', array('class' => 'btn btn-primary btn-lg')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    <?php endif;?>
</div>











