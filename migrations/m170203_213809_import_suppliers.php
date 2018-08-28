<?php

use yii\db\Migration;

class m170203_213809_import_suppliers extends Migration
{
    public function up()
    {
        $sql = file_get_contents( \Yii::getAlias('@app') . '/migrations/supplier.sql');
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('s_address');
        $this->dropTable('s_company');
        $this->dropTable('supplier');
        $this->dropTable('supplier_logo');
    }
}
