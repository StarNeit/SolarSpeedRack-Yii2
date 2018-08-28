<?php

use yii\db\Schema;
use yii\db\Migration;

class m161010_073453_create_product_table extends Migration
{
    public function up()
    {
        $sql = file_get_contents( \Yii::getAlias('@app') . '/migrations/product.sql');
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('price');
        $this->dropTable('product_image');
        $this->dropTable('product_metadata');
        $this->dropTable('product');
        $this->dropTable('product_sub_category');
        $this->dropTable('product_category');
    }
}
