<?php
/* @var $this ProizvodiController */
/* @var $model Proizvodi */
?>

<?php
$this->breadcrumbs=array(
	'Proizvodi'=>array('index'),
	$model->id,
);
?>

<h1>Pregled proizvoda #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'naziv',
		'opis',
		'foto',
		'alt',
		'status',
		'views',
	),
)); ?>