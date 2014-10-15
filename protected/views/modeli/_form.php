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

            <?php 
                if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == "modeli/create"){
             ?>
            <!-- Dimenzije -->
            <br />
             <fieldset>
              <legend>Dimenzija:</legend>
               <div id="dynamicInput">
                       <?php echo $form->textFieldControlGroup($modelDimenzije,'velicina',array('span'=>5,'maxlength'=>255,'name'=>'Dimenzije[velicina_1]','id'=>'Dimenzije_velicina_1')); ?>
                        <?php echo $form->textFieldControlGroup($modelDimenzije,'cena',array('span'=>5,'maxlength'=>255,'name'=>'Dimenzije[cena_1]','id'=>'Dimenzije_cena_1')); ?>
                 </div>
                 <input type="button" value="Add another text input" onClick="addInput('dynamicInput');">
             </fieldset>
             <br />
            <!--  -->
            <?php } ?>

            <?php 
            if(Yii::app()->urlManager->parseUrl(Yii::app()->request) == "modeli/update"){

                $numOfInterations = count($modelDimenzijeUpdate) / 2;
                foreach ($modelDimenzijeUpdate as $update) {
                    for($i = 1; $i <= $numOfInterations; $i++) {
                    ?>
                     <fieldset>
                      <legend>Dimenzija:</legend>
                       <div id="dynamicInput">
                               <?php echo $form->textFieldControlGroup($update,'velicina' ,array('span'=>5,'maxlength'=>255, 'name'=>'Dimenzije[velicina_'.$i.']','id'=>'Dimenzije_velicina_1')); ?>
                                <?php echo $form->textFieldControlGroup($update,'cena' ,array('span'=>5,'maxlength'=>255, 'name'=>'Dimenzije[cena_'.$i.']','id'=>'Dimenzije_cena_1')); ?>
                         </div>
                     </fieldset>
                     <br />
                    <?php
                    }
                }
                ?>
                <input type="button" value="Add another text input" onClick="addInput('dynamicInput');">
                <?php
            }
            ?>

        <div class="form-actions">
        <br>

        <?php echo TbHtml::submitButton($model->isNewRecord ? 'Kreiraj' : 'Sačuvaj',array(
		    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
		    'size'=>TbHtml::BUTTON_SIZE_LARGE,
		)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
var counter = 1;
var limit = 5;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<fieldset><legend>Dimenzija:</legend><label class='control-label required' for='Dimenzije_velicina'>Velicina <span class='required'>*</span></label>" + (counter + 1) + " <br><input name='Dimenzije[velicina_" + (counter + 1) + "]' maxlength='255' id='Dimenzije_velicina_" + (counter + 1) + "' class='span5' type='text'><br><label class='control-label required' for='Dimenzije_velicina'>Cena <span class='required'>*</span></label>" + (counter + 1) + "<br><input name='Dimenzije[cena_" + (counter + 1) + "]' maxlength='255' id='Dimenzije_cena_jk" + (counter + 1) + "' class='span5' type='text'></fieldset>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
</script>