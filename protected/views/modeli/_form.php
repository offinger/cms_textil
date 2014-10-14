<?php
/* @var $this ModeliController */
/* @var $model Modeli */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'modeli-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

    <p class="help-block">Polja sa <span class="required">*</span> su obavezna.</p>
    <?php
    //$putanja = "/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-modeli/";
    $putanja = "/clientpub/images/content-modeli/";
    ?>
    <?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldControlGroup($model,'ime',array('span'=>5,'maxlength'=>255)); ?>

            <?php echo $form->textFieldControlGroup($model,'sifra_modela',array('span'=>5,'maxlength'=>255)); ?>

            <?php echo $form->dropDownListControlGroup($model, 'proizvod_id', $model->getProizvodiOptions()); ?>

            <b>Fotografija:</b> <br>
            <?php $this->widget('ext.DstImageField.DstImageField',array(
                                'model'=>$model,
                                'attribute'=>'foto',
                                'absolute_path' => $putanja, // absolute path where images are stored
                                'preview_width' => '320', // optional attribute - default 160
                                'preview_height' => '200' // optional attribute - default 120
                ));
            ?>

            <b>Banner fotografija:</b> <br>
            <?php $this->widget('ext.DstImageField.DstImageField',array(
                                'model'=>$model,
                                'attribute'=>'foto_banner',
                                'absolute_path' => $putanja, // absolute path where images are stored
                                'preview_width' => '320', // optional attribute - default 160
                                'preview_height' => '200' // optional attribute - default 120
                ));
            ?>
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->getStatusOptions()); ?>

        <div class="form-actions">
                <br>

        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Kreiraj' : 'Sačuvaj',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->