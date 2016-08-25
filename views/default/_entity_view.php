<?php
use yii\helpers\Html;

$asset = testtask\entitieslist\EntitieslistAsset::register($this);
?>
<div class="list-item">
    <div class="row">
        <div class="col-sm-4 col-xs-5">
        <?php
        $entity = $model->entity;

        $entityAttributes = $entity->getEav();

        if($src = $entityAttributes->cover) {
            print Html::img($asset->baseUrl.$src, ['class'=>'img-rounded-entity']);
        }
        ?>
        </div>
        <div class="col-sm-8 col-xs-7">
            <div class="inner">
                <h3 class="entity-title"><?= $entity->name ?></h3>
                <div>
                    <dl>
                        <dt><?= $entity->getAttributeLabel('released_at'); ?></dt>
                        <dd><?= $entity->released_at ?></dd>
                        <?php if($entity->type == 'event'): ?>
                        <dt><?= $entityAttributes->getAttributeLabel('ended_at'); ?></dt>
                        <dd><?= $entityAttributes->ended_at ?></dd>
                        <dt><?= $entityAttributes->getAttributeLabel('place'); ?></dt>
                        <dd><?= $entityAttributes->place ?></dd>
                        <?php elseif($entity->type == 'music'): ?>
                        <dt><?= $entityAttributes->getAttributeLabel('album'); ?></dt>
                        <dd><?= $entityAttributes->album ?></dd>
                        <dt><?= $entityAttributes->getAttributeLabel('artist'); ?></dt>
                        <dd><?= $entityAttributes->artist ?></dd>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-right entity-added-date">
    <small><?= $model->getAttributeLabel('created_at'); ?> <?= $model->created_at ?> by Random:)</small>
</div>