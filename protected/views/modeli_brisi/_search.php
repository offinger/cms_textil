<div class="wide form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

            <?php echo $form->textFieldControlGroup($model,'ime',array('span'=>5,'maxlength'=>255)); ?>
            <?php echo $form->textFieldControlGroup($model,'sifra',array('span'=>5,'maxlength'=>255)); ?>
            <?php echo $form->dropDownListControlGroup($model, 'brend_id', $model->getBrendOptions()); ?>
            <?php echo $form->dropDownListControlGroup($model, 'kategorija', $model->getKategorijaOptions()); ?>
            <?php echo $form->dropDownListControlGroup($model, 'kolekcija_id', $model->getKolekcijaOptions()); ?>
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->getStatusOptions()); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton('Pretraži',  array('color' => TbHtml::BUTTON_COLOR_PRIMARY,));?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->