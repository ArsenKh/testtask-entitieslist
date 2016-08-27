<?php

namespace testtask\entitieslist\models;

use Yii;

/**
 * This is the model class for table "entitieslist_entity".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $released_at
 *
 * @property EavAttribute[] $eavAttributes
 * @property EavAttributeValue[] $eavAttributeValues
 * @property StackOfEntities[] $stackOfEntities
 */
class Entity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entitieslist_entity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['released_at'], 'safe'],
            [['type'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'released_at' => 'Released At',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavAttributes()
    {
        return $this->hasMany(EavAttribute::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEavAttributeValues()
    {
        return $this->hasMany(EavAttributeValue::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStackOfEntities()
    {
        return $this->hasMany(StackOfEntities::className(), ['entity_id' => 'id']);
    }

    /**
     * @inheritdoc
     *
     * implementation STI pattern for every type of event
     */
    public static function instantiate($row)
    {
        switch ($row['type']) {
            case EntityFilm::TYPE:
                return new EntityFilm();
            case EntityMusic::TYPE:
                return new EntityMusic();
            case EntityEvent::TYPE:
                return new EntityEvent();
            default:
                return new self;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /// * use EAV pattern for additional/custom params
            'eav' => [
                'class' => \testtask\entitieslist\behaviors\EavBehavior::className(),
                'valueClass' => \testtask\entitieslist\models\EavAttributeValue::className(),
                'attributeClass' => \testtask\entitieslist\models\EavAttribute::className(),
            ]
        ];
    }
}
