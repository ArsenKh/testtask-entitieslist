<?php
use yii\helpers\Html;
use yii\helpers\Url;

$asset = testtask\entitieslist\EntitieslistAsset::register($this);
?>
<div class="row">
    <div class="col-sm-4">
    <?php
    $entity = $model->entity;

    $entityAttributes = $entity->getEav();

    if($src = $entityAttributes->cover) {
        print Html::img($asset->baseUrl.$src, ['class'=>'img-rounded-entity']);
    }

    $typeIconClass = '';
    if($entity->type == 'film') {
        $typeIconClass = 'glyphicon-film';
    } elseif($entity->type == 'music') {
        $typeIconClass = 'glyphicon-headphones';
    } elseif($entity->type == 'event') {
        $typeIconClass = 'glyphicon-bookmark';
    }
    ?>
    </div>
    <div class="col-sm-8">
        <h3 class="entity-title"><span class="glyphicon <?= $typeIconClass ?>" aria-hidden="true"></span> <?= $entity->name ?></h3>
        <div class="row">
            <div class="col-sm-6">
                <dl>
                    <dt><?= $model->getAttributeLabel('created_at'); ?></dt>
                    <dd><?= $model->created_at ?></dd>

                    <dt><?= $entity->getAttributeLabel('released_at'); ?></dt>
                    <dd><?= $entity->released_at ?></dd>

                    <?php if($entity->type == 'event'): ?>
                    <dt><?= $entityAttributes->getAttributeLabel('ended_at'); ?></dt>
                    <dd><?= $entityAttributes->ended_at ?></dd>
                    <?php endif; ?>
                </dl>
             </div>
             <div class="col-sm-6">
                 <dl>
                 <?php if($entity->type == 'event'): ?>
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