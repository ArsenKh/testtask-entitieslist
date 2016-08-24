<?php

use yii\db\Migration;
use yii\db\Schema;

class m160823_220316_create_new_tables extends Migration
{
    public $tables;
    public $entityName = 'entitieslist';
    public $attributeTypes = [];

    public function init()
    {
        if (!$entityName = $this->entityName) {
            throw new \yii\console\Exception("Entity name must be set for Entities List migration");
        }

        $this->tables = [
            'entity' => "{{%{$entityName}_entity}}",
            'list' => "{{%{$entityName}_stack_of_entities}}",
            'attribute' => "{{%{$entityName}_eav_attribute}}",
            'value' => "{{%{$entityName}_eav_attribute_value}}",
        ];
    }

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $options = $this->db->driverName == 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
            : null;

        $this->createTable($this->tables['entity'], [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'type' => Schema::TYPE_STRING,
            'released_at' => Schema::TYPE_TIMESTAMP,
        ], $options);

        $this->createTable($this->tables['list'], [
            'id' => Schema::TYPE_PK,
            'entity_id' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_TIMESTAMP,
        ], $options);

        $this->createTable($this->tables['attribute'], [
            'id' => Schema::TYPE_PK,
            'entity_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING,
        ], $options);

        $this->createTable($this->tables['value'], [
            'id' => Schema::TYPE_PK,
            'entity_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'attribute_id' => Schema::TYPE_INTEGER. ' NOT NULL',
            'value' => Schema::TYPE_STRING,
        ], $options);

        if($this->db->driverName != "sqlite") {
            $this->addForeignKey('FK_List_entity_id',
                $this->tables['list'], 'entity_id', $this->tables['entity'], 'id', "CASCADE", "NO ACTION");

            $this->addForeignKey('FK_Attribute_entity_id',
                $this->tables['attribute'], 'entity_id', $this->tables['entity'], 'id', "CASCADE", "NO ACTION");

            $this->addForeignKey('FK_Value_entity_id',
                $this->tables['value'], 'entity_id', $this->tables['entity'], 'id', "CASCADE", "NO ACTION");

            $this->addForeignKey('FK_Value_attribute_id',
                $this->tables['value'], 'attribute_id', $this->tables['attribute'], 'id', "CASCADE", "NO ACTION");
        }
    }

    public function safeDown()
    {
        if($this->db->driverName != "sqlite") {
            $this->dropForeignKey('FK_List_entity_id', $this->tables['list']);
            $this->dropForeignKey('FK_Attribute_entity_id', $this->tables['attribute']);
            $this->dropForeignKey('FK_Value_entity_id', $this->tables['value']);
            $this->dropForeignKey('FK_Value_attribute_id', $this->tables['value']);
        }

        $this->dropTable($this->tables['attribute']);
        $this->dropTable($this->tables['value']);
        $this->dropTable($this->tables['option']);
        $this->dropTable($this->tables['list']);
    }
}
