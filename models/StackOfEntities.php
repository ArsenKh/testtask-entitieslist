<?php

namespace testtask\entitieslist\models;

use Yii;

/**
 * This is the model class for table "entitieslist_stack_of_entities".
 *
 * @property string $id
 * @property string $entity_id
 *
 * @property Entity $entity
 */
class StackOfEntities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entitieslist_stack_of_entities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id'], 'required'],
            [['entity_id'], 'integer'],
            [['entity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entity::className(), 'targetAttribute' => ['entity_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(Entity::className(), ['id' => 'entity_id']);
    }
}
