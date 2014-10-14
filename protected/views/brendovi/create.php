<?php
/* @var $this BrendoviController */
/* @var $model Brendovi */
?>

<?php
$this->breadcrumbs=array(
	'Brendovi'=>array('index'),
	'Unos novog brenda',
);

?>

<h1>Unos novog brenda</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>