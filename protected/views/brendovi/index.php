<?php
$this->breadcrumbs=array(
	'Brendovi',
);
?>

<h1>Brendovi</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>