<?php

use yii\db\Migration;

class m161108_073649_create_accessory_tables extends Migration
{
    public function up()
    {
        $sql = file_get_contents( \Yii::getAlias('@app') . '/migrations/accessory.sql');
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('accessory_product');
        $this->dropTable('accessory');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
