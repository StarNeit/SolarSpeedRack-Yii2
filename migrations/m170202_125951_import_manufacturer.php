<?php

use yii\db\Migration;

class m170202_125951_import_manufacturer extends Migration
{
    public function up()
    {
        $sql = file_get_contents( \Yii::getAlias('@app') . '/migrations/manufacturer.sql');
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('manufacturer');
    }
}
