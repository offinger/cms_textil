<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ime')); ?>:</b>
	<?php echo CHtml::encode($data->ime); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('sifra_modela')); ?>:</b>
	<?php echo CHtml::encode($data->sifra_modela); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foto')); ?>:</b>
	<?php echo CHtml::encode($data->foto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php 
	if($data->status==1) {
		echo '<span class="badge badge-success"> Aktivna </span>';
	} else {
		echo '<span class="badge badge-danger"> Neaktivna </span>';
	}

	?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('views')); ?>:</b>
	<?php echo CHtml::encode($data->views); ?>
	<br />


</div>