<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\EntitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => 1, 'class' => 'form-inline'],
        'id' => 'entity-search-form'
    ]); ?>

    <?= $form->field($model, 'type', ['template' => '{label} {input}'])->dropDownList([
        'film' => 'Films',
        'music' => 'Musics',
        'event' => 'Events',
    ], ['prompt'=>'...']); ?>

    <?= $form->field($model, 'date', ['template' => '{label} {input}'])->widget(DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class'=>'form-control']
    ]) ?>

    <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::button('Reset', ['class' => 'btn btn-default', 'id' => 'reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
