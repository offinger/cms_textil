<?php
$this->breadcrumbs=array(
	'Kolekcije',
);
?>

<h1>Kolekcije</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>