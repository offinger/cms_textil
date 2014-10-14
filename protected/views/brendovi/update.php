<?php
$this->breadcrumbs=array(
	'Brendovi'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Izmena',
);

?>
<h1>Izmena Brenda: <?php echo $model->id; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>