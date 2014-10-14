<?php
/* @var $this BrendoviController */
/* @var $model Brendovi */
?>

<?php
$this->breadcrumbs=array(
	'Brendovi'=>array('index'),
	$model->id,
);
?>

<h1>Pregled brenda #<?php echo $model->id; ?></h1>

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