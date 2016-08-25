<?php
namespace testtask\entitieslist\components;

use Yii;
use yii\base\DynamicModel as BaseEavModel;
use yii\db\ActiveRecord;
use testtask\entitieslist\components\AttributeHandler;
use testtask\entitieslist\components\ValueHandler;
/**
 * Class EavModel
 */
class EavModel extends BaseEavModel
{
    /** @var string Class to use for storing data */
    public $valueClass;
    /** @var string Class to use for storing attribute */
    public $attributeClass;
    /** @var ActiveRecord */
    public $entityModel;
    /** @var AttributeHandler[] */
    public $handlers;

    /**
     * Constructor for creating form model from entity object
     *
     * @param array $params
     * @return static
     */
    public static function create($params)
    {
        $params['class'] = static::className();

        /** @var static $model */
        $model = Yii::createObject($params);

        $params = [];

        if(!empty($params['attribute'])){
          $params = ['name' => $params['attribute']];
        }

        $attributes = $model
          ->entityModel
          ->getRelation('eavAttributes')
          ->where($params)
          ->all();

        foreach ($attributes as $attribute) {

            $handler = AttributeHandler::load($model, $attribute);
            $key = $handler->getAttributeName();
            $value = $handler->valueHandler->getTextValue();
            /// * Add define attribute
            $model->defineAttribute($key, $value);
            /// * Add handler
            $model->handlers[$key] = $handler;

        }

        return $model;
    }

    public function save($runValidation = true, $attributes = null)
    {
        if(!$this->handlers){
          Yii::info('Dynamic model data were no attributes.', __METHOD__);
          return false;
        }

        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Dynamic model data were not save due to validation error.', __METHOD__);
            return false;
        }

        $db = $this->entityModel->getDb();

        $transaction = $db->beginTransaction();
        try {
            foreach ($this->handlers as $handler) {
                if($handler->attributeModel->isNewRecord) {
                    $handler->attributeModel->entity_id = $this->entityModel->getPrimaryKey();
                    if(!$handler->attributeModel->save()) {
                        throw new \Exception("Can't save attribute model");
                    }
                }
                $handler->valueHandler->save();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    
    public function __set($name, $value)
    {
        if(!isset($this->handlers[$name])) {
            $attributeClass = new $this->attributeClass;
            $attributeClass->name = $name;
            $handler = AttributeHandler::load($this, $attributeClass);
            /// * Add define attribute
            $this->defineAttribute($name, $value);
            /// * Add handler
            $this->handlers[$name] = $handler;
        }
        $this->defineAttribute($name, $value);
    }
}