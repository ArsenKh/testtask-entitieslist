<?php

namespace testtask\entitieslist\models;

use Yii;

/**
 * This is the model class for table "entitieslist_eav_attribute".
 *
 * @property string $id
 * @property string $entity_id
 * @property string $name
 *
 * @property Entity $entity
 * @property EavAttributeValue[] $eavAttributeValues
 */
class EavAttribute extends \yii\db\ActiveRecord
{
    const DEFAULT_VALUE_HANDLER = "\\testtask\\entitieslist\\components\\ValueHandler";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entitieslist_eav_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(Entity::className(), ['id' => 'entity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavAttributeValues()
    {
        return $this->hasMany(EavAttributeValue::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getValueHandler()
    {
        return self::DEFAULT_VALUE_HANDLER;
    }
}
