<?php

use yii\db\Schema;
use yii\db\Migration;

class m161010_073455_settings_and_email_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable('settings', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'value' => Schema::TYPE_STRING . '(255) DEFAULT NULL'
        ], $tableOptions);
        
        $this->createTable('email_campaign', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(100) NOT NULL',
            'template_id' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);
        
        $this->createTable('email_config', [
            'id' => Schema::TYPE_PK,
            'default' => Schema::TYPE_INTEGER . '(1) DEFAULT 0',
            'from_name' => Schema::TYPE_STRING . '(100) NOT NULL',
            'from_email' => Schema::TYPE_STRING . '(100) NOT NULL',
            'replyto_name' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'replyto_email' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'cc_emails' => Schema::TYPE_TEXT . ' DEFAULT NULL'
        ], $tableOptions);
        
        $this->createTable('email_template', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(100) NOT NULL',
            'subject' => Schema::TYPE_STRING . '(255) NOT NULL',
            'content' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'macros' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'last_updated' => Schema::TYPE_TIMESTAMP
        ], $tableOptions);
        
        $this->addForeignKey('email_campaign_tpl_id', 'email_campaign', 'template_id', 'email_template', 'id');
    }

    public function down()
    {
        return TRUE;
    }

}
