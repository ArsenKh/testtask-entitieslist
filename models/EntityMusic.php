<?php

namespace testtask\entitieslist\models;

use Yii;
use testtask\entitieslist\components\EntityQuery;

/**
 * This is the model class for table "entitieslist_entity".
 */
class EntityMusic extends Entity
{
    const TYPE = 'music';

    public function init()
    {
        $this->type = self::TYPE;

        parent::init();
    }

    public static function find()
    {
        return new EntityQuery(get_called_class(), ['type' => self::TYPE]);
    }

    public function beforeSave($insert)
    {
        $this->type = self::TYPE;

        return parent::beforeSave($insert);
    }
}