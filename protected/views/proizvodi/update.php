<?php
$this->breadcrumbs=array(
	'Proizvodi'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Izmena',
);

?>
<h1>Izmena Proizvoda: <?php echo $model->id; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>