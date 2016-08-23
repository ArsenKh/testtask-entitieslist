<?php
namespace testtask\entitieslist\components;

use yii\db\ActiveQuery;

class EntityQuery extends ActiveQuery
{
    public $type;

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(['type' => $this->type]);
        }

        return parent::prepare($builder);
    }
}