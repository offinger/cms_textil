<?php
$this->breadcrumbs=array(
	'Modeli'=>array('index'),
	'Upravljanje modelima',
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#modeli-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Upravljanje modelima</h1>

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
	'id'=>'modeli-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText'=>'Prikazano {start} od {end} ukupno modela',

	'columns'=>array(
/*		'ime',*/
		'sifra',
		array(
            		'name' => 'brend_id',
            		'filter' => CHtml::listData(Brendovi::model()->findAll(), 'id', 'naziv'),
            		'value' => Brendovi::Model()->findByPk($data->brend_id),
       	),
       	/*
    	array(
        	'name'=>'kategorija',
        	'value'=>$model->kategorija,
        	'filter'=>$model->getKategorijaOptions(),
    	),
    	*/
    	'cena',
    	array(
            	'name' => 'kolekcija_id',
            	'filter' => CHtml::listData(Kolekcije::model()->findAll(), 'id', 'ime'),
            	'value' => Kolekcije::Model()->findByPk($data->kolekcija_id),
        ),
    	array(
        	'name'=>'status',
        	'value'=>$model->status,
        	'filter'=>$model->getStatusOptions(),
    	),
		/*
		'views',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
 			'template'=>'{update} {delete}',
            'buttons'=>array
            (
                'update' => array
                (
                    'label'=>'Izmeni',
                    'url'=>'Yii::app()->createUrl("modeli/update", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-success',
                    ),
                ),
                'delete' => array
                (
                    'label'=>'Obrisi',
                    'url'=>'Yii::app()->createUrl("modeli/delete", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small btn-danger',
                    ),
                ),

            ),
			
		),
	),
)); ?>