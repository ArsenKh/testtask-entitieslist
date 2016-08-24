<?php
use yii\helpers\Html;
use yii\helpers\Url;

$asset = testtask\entitieslist\EntitieslistAsset::register($this);
?>
<div class="col-sm-4">
<?php
if($src = $model->getEav()->cover) {
	print Html::img($asset->baseUrl.$src, ['class'=>'img-rounded entity-cover']);
}
?>
</div>
<div class="col-sm-8">
	<h3><?= $model->name ?></h3>
</div>