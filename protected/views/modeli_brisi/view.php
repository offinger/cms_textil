<?php
$this->breadcrumbs=array(
	'Modeli'=>array('index'),
	$model->id,
);
?>

<h1>Pregled Modela #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'ime',
		'sifra',
		'brend.naziv',
		'foto',
		'kategorija',
		'kolekcija.ime',
		'status',
		'views',
	),
)); ?>