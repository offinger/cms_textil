<?php
/* @var $this KolekcijeController */
/* @var $model Kolekcije */
?>

<?php
$this->breadcrumbs=array(
	'Kolekcije'=>array('index'),
	$model->id,
);
?>

<h1>Pregled Kolekcije #<?php echo $model->id; ?></h1>

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