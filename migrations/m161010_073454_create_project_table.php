<?php

use yii\db\Schema;
use yii\db\Migration;

class m161010_073454_create_project_table extends Migration
{
    public function up()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . "(100) DEFAULT NULL",
            'address' => Schema::TYPE_STRING . "(255) DEFAULT NULL",
            'zip_code' => Schema::TYPE_STRING . "(6) DEFAULT 0",
            'total_watt' => Schema::TYPE_STRING . "(100) DEFAULT NULL",
            'total_material' => Schema::TYPE_STRING . "(100) DEFAULT NULL",
            'cost_per_watt' => Schema::TYPE_STRING . "(100) DEFAULT NULL",
            'cost_per_panel' => Schema::TYPE_STRING . "(100) DEFAULT NULL",
            'layout' => 'blob DEFAULT NULL',
            'config' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'created_by' => Schema::TYPE_INTEGER . '(11)',
            'updated_by' => Schema::TYPE_INTEGER . '(11)',
            'created_at' => Schema::TYPE_INTEGER . '(11)',
            'updated_at' => Schema::TYPE_INTEGER . '(11)',
            'status' => Schema::TYPE_INTEGER . '(1) DEFAULT 1'
        ]);

        $this->createTable('project_part', [
            'id' => $this->primaryKey(),
            'project_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'product_id' => Schema::TYPE_INTEGER . "(11) NOT NULL",
            'quantity' => Schema::TYPE_INTEGER . "(11) NOT NULL",
        ]);

        $this->addForeignKey('part_project_id', 'project_part', 'project_id', 'project', 'id');
        $this->addForeignKey('part_product_id', 'project_part', 'product_id', 'product', 'id');

//        $this->addColumn('order', 'project_id', Schema::TYPE_INTEGER . "(11) NOT NULL");
//        $this->addForeignKey('order_project_id', 'order', 'project_id', 'project', 'id');
    }

    public function down()
    {
        $this->dropTable('project');
    }
}
