<?php
$this->breadcrumbs=array(
	'Proizvodi'=>array('index'),
	'Upravljanje',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#proizvodi-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Upravljanje proizvodima</h1>
<p>
    Opcino možete koristiti neki od komparacionih pokazatelja (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
ili <b>=</b>) na početku Vaše pretrage kako bi ste odredili kako da pretraga bude izvšena.
</p>

<?php echo CHtml::link('Napredna pretraga','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'proizvodi-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'Prikazano {start} od {end} ukupno proizvoda',
	'columns'=>array(
		'naziv',
		'alt',
		 array(
        	'name'=>'status',
        	'value'=>$model->status,
        	'filter'=>$model->getStatusOptions(),
    	),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			 'template'=>'{update} {delete}',
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>'Izmeni',
                    'url'=>'Yii::app()->createUrl("proizvodi/update", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-success',
                    ),
                ),
                'delete' => array
                (
                    'label'=>'Obrisi',
                    'url'=>'Yii::app()->createUrl("proizvodi/delete", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-danger',
                    ),
                ),

            ),
			
		),
	),
)); ?>