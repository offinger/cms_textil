<?php
$this->breadcrumbs=array(
	'Kolekcije'=>array('index'),
	'Unos nove kolekcije',
);
?>

<h1>Unos nove kolekcije</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>