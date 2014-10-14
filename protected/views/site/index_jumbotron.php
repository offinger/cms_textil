<?php $this->pageTitle = Yii::app()->name; ?>
<div class="jumbotron">


    <div class="container">
</div>
<a href="http://www.tgroupco.co.rs" target="_blank"><button type="button" class="btn btn-info">TGroupCo sajt</button></a>
<a href="/control/brendovi/admin"><button type="button" class="btn btn-default btn-circle btn-xxl">Brendovi</button></a>
<a href="/control/modeli/admin"><button type="button" class="btn btn-primary btn-circle btn-xl">Modeli</button></a>
<a href="/control/kolekcije/admin"><button type="button" class="btn btn-success btn-circle btn-xl">Kolekcije</button></a>
<a href="logout" target="_blank"><button type="button" class="btn btn-danger">Odjava</button></a>

</div>
<div id="panel-stats">
<legend> Statistika: </legend>
        <span class="label label-default">Broj brendova: <?php echo $brojBrendova; ?></span>
        <span class="label label-primary">Broj modela: <?php echo $brojModela; ?></span>
        <span class="label label-success">Broj kolekcija: <?php echo $brojKolekcija; ?></span>
</div>
