<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EntitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entities List';
/* @var $this \yii\web\View */
/* @var $content string */
?>
<div class="default-index">

	<div class="page-header">
		<h1>Entities List, <small>test task ...</small></h1>
	</div>

	<?php echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php Pjax::begin(); ?>
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'options' => [
			'tag' => 'div',
			'class' => 'list-wrapper',
			'id' => 'list-wrapper',
		],
		'itemOptions' => [
			'class' => 'row list-item-view-wrapper',
		],
		'layout' => "{summary}\n{items}\n{pager}",
		'itemView' => '_entity_view',
	]); ?>
	<?php Pjax::end(); ?></div>
</div>