<?php
$this->breadcrumbs=array(
	'Kolekcije'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Izmena',
);
?>

<h1>Izmena Kolekcije: <?php echo $model->id; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>