<?php
namespace testtask\entitieslist\behaviors;

use testtask\entitieslist\components\EavModel;
use testtask\entitieslist\models\EavAttribute;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class EavBehavior
 *
 * @mixin ActiveRecord
 * @property EavModel $EavModel;
 * @property ActiveRecord $owner
 */
class EavBehavior extends Behavior
{
    public $valueClass;
    public $attributeClass;

    protected $EavModel;

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function init()
    {
        assert(isset($this->valueClass));
        assert(isset($this->valueClass));
    }

    public function defineEavAttribute($name, $value)
    {
        $this->getEav()->{$name} = $value;
    }

    public function getLabel($attribute)
    {
        return EavAttribute::find()->select(['label'])->where(['name' => $attribute])->scalar();
    }

    public function afterSave()
    {
        $this->getEav()->save(false);
    }

    public function getEav()
    {
        if(!($this->EavModel instanceof EavModel)) {
            $this->EavModel = EavModel::create([
                'entityModel' => $this->owner,
                'valueClass' => $this->valueClass,
                'attributeClass' => $this->attributeClass,
            ]);
        }

        return $this->EavModel;
    }
}