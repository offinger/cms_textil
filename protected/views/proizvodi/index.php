<?php
$this->breadcrumbs=array(
	'Proizvodi',
);
?>

<h1>Proizvodi</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>