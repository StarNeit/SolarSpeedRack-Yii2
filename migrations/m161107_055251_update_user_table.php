<?php

use yii\db\Migration;
use yii\db\Schema;

class m161107_055251_update_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'disclaimer', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
        $this->addColumn('user', 'last_login', Schema::TYPE_INTEGER . ' DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'disclaimer');
        $this->dropColumn('user', 'last_login');
    }
}
