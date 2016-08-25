<?php
namespace testtask\entitieslist\components;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class AttributeHandler
 */
class AttributeHandler
{
    /** @var EavModel */
    public $owner;
    /** @var ValueHandler */
    public $valueHandler;
    /** @var ActiveRecord */
    public $attributeModel;
    
    public $nameField = 'name';

    /**
     * @param EavModel $owner
     * @param ActiveRecord $attributeModel
     * @return AttributeHandler
     * @throws \yii\base\InvalidConfigException
     */
    public static function load($owner, $attributeModel)
    {
        $handler = Yii::createObject([
            'class' => __CLASS__,
            'owner' => $owner,
            'attributeModel' => $attributeModel
        ]);
        $handler->init();

        return $handler;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->valueHandler = Yii::createObject([
            'class' => $this->attributeModel->getValueHandler(),
            'attributeHandler' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function getAttributeName()
    {
        return (string)($this->attributeModel->{$this->nameField});
    }
}