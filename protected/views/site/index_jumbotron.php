<?php $this->pageTitle = Yii::app()->name; ?>
<div class="jumbotron">


    <div class="container">
</div>
<a href="http://cms.local/" target="_blank"><button type="button" class="btn btn-info">Početna</button></a>
<a href="/proizvodi/admin"><button type="button" class="btn btn-default btn-circle btn-xxl">Proizvodi</button></a>
<a href="/modeli/admin"><button type="button" class="btn btn-primary btn-circle btn-xl">Modeli</button></a>
<a href="logout" target="_blank"><button type="button" class="btn btn-danger">Odjava</button></a>

</div>
<div id="panel-stats">
<legend> Statistika: </legend>
        <span class="label label-default">Broj proizvoda: <?php echo $brojProizvoda; ?></span>
        <span class="label label-primary">Broj modela: <?php echo $brojModela; ?></span>
</div>
<?php $this->widget('application.widgets.GoogleAnalyticsWidget'); ?>