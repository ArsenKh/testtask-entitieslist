<?php
namespace testtask\entitieslist\components;

use yii\db\ActiveRecord;

/**
 * Class ValueHandler
 *
 * @property ActiveRecord $valueModel
 * @property string $textValue
 */
class ValueHandler
{
    /** @var AttributeHandler */
    public $attributeHandler;

    /**
     * @return ActiveRecord
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function load()
    {
        $EavModel = $this->attributeHandler->owner;

        /** @var ActiveRecord $valueClass */
        $valueClass = $EavModel->valueClass;

        $valueModel = $valueClass::findOne([
            'entity_id' => $EavModel->entityModel->getPrimaryKey(),
            'attribute_id' => $this->attributeHandler->attributeModel->getPrimaryKey(),
        ]);

        if (!$valueModel instanceof ActiveRecord) {
            /** @var ActiveRecord $valueModel */
            $valueModel = new $valueClass;
            $valueModel->entity_id = $EavModel->entityModel->getPrimaryKey();
            $valueModel->attribute_id = $this->attributeHandler->attributeModel->getPrimaryKey();
        }

        return $valueModel;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $EavModel = $this->attributeHandler->owner;
        $valueModel = $this->load();
        $attribute = $this->attributeHandler->getAttributeName();

        if(isset($EavModel->attributes[$attribute])){

            $valueModel->value = $EavModel->attributes[$attribute];

            if (!$valueModel->save())
                throw new \Exception("Can't save value model");

        }
    }

    public function getTextValue()
    {
        return $this->load()->value;
    }
}