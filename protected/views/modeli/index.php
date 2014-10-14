<?php
$this->breadcrumbs=array(
	'Modeli',
);
?>

<h1>Modeli</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>