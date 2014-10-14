<?php
/* @var $this ModeliController */
/* @var $model Modeli */
?>

<?php
$this->breadcrumbs=array(
	'Modeli'=>array('index'),
	$model->id,
);
?>

<h1>Pregled modela #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'ime',
		'foto',
		'status',
	),
)); ?>