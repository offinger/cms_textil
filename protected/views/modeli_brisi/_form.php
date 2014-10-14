<script type="text/javascript">
    
function ucitajKolekcije(brend) {
  $('#kolekcijaDiv').html('<img src="http://www.nhscjobs.hrsa.gov/external/assets/images/ajax-loader.gif"> Molimo sačekajte..</img>');
   $.ajax({
     type: "GET",
     url: '/modeli/getKolekcije?brend='+brend,
     success: function(data) {
          $('#kolekcijaDiv').html(data);
     }
   });
}

</script>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'modeli-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

    <p class="help-block">Polja sa <span class="required">*</span> su obavezna.</p>

    <?php echo $form->errorSummary($model); ?>
    <?php

        //$putanja = "/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-model/";
         $putanja = "/clientpub/images/content-model/";

    ?>
            <?php echo $form->textFieldControlGroup($model,'sifra',array('span'=>5,'maxlength'=>255)); ?>
            <?php echo $form->dropDownListControlGroup($model, 'brend_id', $model->getBrendOptions(), array("onChange" => 'ucitajKolekcije(this.value)')); ?>
            <b>Fotografija:</b> <br>
            <?php $this->widget('ext.DstImageField.DstImageField',array(
                                'model'=>$model,
                                'attribute'=>'foto',
                                'absolute_path' => $putanja, // absolute path where images are stored
                                'preview_width' => '320', // optional attribute - default 160
                                'preview_height' => '200' // optional attribute - default 120
                ));
            ?>
            <?php echo $form->dropDownListControlGroup($model, 'kategorija', $model->getKategorijaOptions()); ?>
            <?php //echo $form->dropDownListControlGroup($model, 'kolekcija_id', $model->getKolekcijaOptions()); ?>
            <div id="kolekcijaDiv"> </div>
            <?php echo $form->dropDownListControlGroup($model, 'status', $model->getStatusOptions()); ?>
            <fieldset> 
            	<legend> Dodatni atributi: </legend>
                        <?php echo $form->textFieldControlGroup($model,'cena',array('span'=>3,'maxlength'=>8)); ?>
                        <?php echo $form->textFieldControlGroup($model,'mehanizam',array('span'=>5,'maxlength'=>255)); ?>
                        <?php echo $form->textFieldControlGroup($model,'velicina_kucista',array('span'=>5,'maxlength'=>255)); ?>
            </fieldset>

        <div class="form-actions">
        <br>
        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Kreiraj' : 'Sačuvaj',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->