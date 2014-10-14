<?php
$this->pageTitle=Yii::app()->name . ' - Greška';
$this->breadcrumbs=array(
	'Greška',
);
?>
<div class="page-min-height">
<h2 class="page-header" >Greška <?php echo $code; ?></h2>

<div class="alert alert-warning">
<?php echo CHtml::encode($message); ?>
</div>
</div>