<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Entities List';
/* @var $this \yii\web\View */
/* @var $content string */
?>
<div class="default-index">

    <header class="main-header">
        <div class="clearfix">
            <div class="pull-left">
                <h1>Events List</h1>
            </div>
            <div class="pull-right">
                <?php
                Modal::begin(
                    [
                        'id' => 'statistic-modal',
                        'size' => Modal::SIZE_SMALL,
                        'options' => ['class' => 'slide'],
                        'toggleButton' => ['label' => 'Statistic', 'class' => 'btn btn-default'],
                    ]
                );
                Modal::end();
                ?>
                <?= Html::a('Refresh', ['default/index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </header>

    <?php
    $this->registerJs(
    '$("document").ready(function() {
        $("#entity_search").on("pjax:end", function() {
            $.pjax.reload({container:"#entities_list_view_wrapper"});
        });
        $("#statistic-modal").on("show.bs.modal", function (e) {
            $.ajax({
                url: "'.Url::to(['default/stat']).'"
            }).done(function(data) {
                $(".modal-body").html(data);
            });
        }).on("hide.bs.modal", function (e) {
            $(".modal-body").html("Please wait ...");
        });
    });'
    );
    ?>

    <div class="text-right">
    <?php Pjax::begin([
        'timeout' => 999999,
        'id' => 'entity_search'
    ]); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::end(); ?>
    </div>

    <?php Pjax::begin([
        'timeout' => 9999999,
        'id' => 'entities_list_view_wrapper'
    ]); ?>

    <?= ListView::widget([
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
        'pager' => ['maxButtonCount' => 5]
    ]); ?>

    <?php Pjax::end(); ?></div>
</div>