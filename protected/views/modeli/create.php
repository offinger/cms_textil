<?php
$this->breadcrumbs=array(
	'Modeli'=>array('index'),
	'Unos novog modela',
);
?>

<h1>Unos novog modela</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>