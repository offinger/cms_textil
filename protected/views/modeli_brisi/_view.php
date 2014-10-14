<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ime')); ?>:</b>
	<?php echo CHtml::encode($data->ime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sifra')); ?>:</b>
	<?php echo CHtml::encode($data->sifra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brend_id')); ?>:</b>
	<?php 
	echo CHtml::encode($data->brend->naziv); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foto')); ?>:</b>
	<?php echo CHtml::encode($data->foto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kategorija')); ?>:</b>
	<?php echo CHtml::encode($data->kategorija); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kolekcija_id')); ?>:</b>
	<?php echo CHtml::encode($data->kolekcija->ime); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('views')); ?>:</b>
	<?php echo CHtml::encode($data->views); ?>
	<br />

	*/ ?>

</div>