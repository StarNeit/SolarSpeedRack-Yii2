<?php

use yii\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m161107_162500_create_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $sql = file_get_contents( \Yii::getAlias('@app') . '/migrations/message.sql');
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message');
        $this->dropTable('project_activity');
        $this->dropTable('project_activity_list');
    }
}
