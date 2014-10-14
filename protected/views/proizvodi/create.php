<?php
/* @var $this ProizvodiController */
/* @var $model Proizvodi */
?>

<?php
$this->breadcrumbs=array(
	'Proizvodi'=>array('index'),
	'Unos novog brenda',
);

?>

<h1>Unos novog proizvoda</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>