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

	<?php
	$this->registerJs(
		'$("document").ready(function(){
            $("#entity_search").on("pjax:end", function() {
            $.pjax.reload({container:"#entities_list_view"});
        });
    });'
	);
	?>
	<?php Pjax::begin(['id' => 'entity_search']) ?>
	<?= $this->render('_search', ['model' => $searchModel]); ?>
	<?php Pjax::end(); ?>

    <?php Pjax::begin([
        'enablePushState' => true,
        'enableReplaceState' => true,
        'timeout' => 6000,
    ]); ?>

    <?= ListView::widget([
	    'id' => 'entities_list_view',
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'itemOptions' => [
            'class' => 'list-item-view-wrapper',
        ],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => '_entity_view',
    ]); ?>

    <?php Pjax::end(); ?></div>
</div>