<?php
$this->breadcrumbs=array(
	'Kolekcijes'=>array('index'),
	'Upravljanje',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#kolekcije-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Upravljanje kolekcijama</h1>

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
	'id'=>'kolekcije-grid',
	'dataProvider'=>$model->search(),

	'filter'=>$model,
	'summaryText'=>'Prikazano {start} od {end} ukupno kolekcija',

	'columns'=>array(
		'ime',
		array(
            		'name' => 'brend_id',
            		'filter' => CHtml::listData(Brendovi::model()->findAll(), 'id', 'naziv'),
            		'value' => Brendovi::Model()->findByPk($data->brend_id),
        	),
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
                    'url'=>'Yii::app()->createUrl("kolekcije/update", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-success',
                    ),
                ),
                'delete' => array
                (
                    'label'=>'Obrisi',
                    'url'=>'Yii::app()->createUrl("kolekcije/delete", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-danger',
                    ),
                ),

            ),
			
		),
	),
)); ?>