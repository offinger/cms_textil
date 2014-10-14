<?php
/* @var $this BrendoviController */
/* @var $model Brendovi */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
                    <?php echo $form->textFieldControlGroup($model,'id',array('span'=>5)); ?>
                    <?php echo $form->textFieldControlGroup($model,'naziv',array('span'=>5,'maxlength'=>255)); ?>
                    <?php echo $form->textFieldControlGroup($model,'opis',array('span'=>5,'maxlength'=>2000)); ?>
                    <?php echo $form->textFieldControlGroup($model,'alt',array('span'=>5,'maxlength'=>255)); ?>
                    <?php echo $form->dropDownListControlGroup($model, 'status', $model->getStatusOptions()); ?>

        <div class="form-actions">
        <?php echo TbHtml::submitButton('Pretraži',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->