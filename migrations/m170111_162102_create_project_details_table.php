<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project_details`.
 * Has foreign keys to the tables:
 *
 * - `project`
 * - `user`
 * - `user`
 */
class m170111_162102_create_project_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('project_details', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'installer_id' => $this->integer()->notNull(),
            'inspection_date' => $this->date(),
            'inspection_time' => $this->integer(),
            'inspection_detail' => $this->text(),
            'installation_date' => $this->date(),
            'installation_time' => $this->integer(),
            'installation_detail' => $this->text(),
            'inspection_status' => $this->integer(1),
            'installation_status' => $this->integer(1),
            'customer_confirmation' => $this->integer(1),
            'permit_plan_id' => $this->integer(),
            'permit_plan_status' => $this->integer(1),
            'products_shipped' => $this->integer(1),
            'completion_form_submitted' => $this->integer(1),
        ]);

        // creates index for column `project_id`
        $this->createIndex(
            'idx-project_details-project_id',
            'project_details',
            'project_id'
        );

        // add foreign key for table `project`
        $this->addForeignKey(
            'fk-project_details-project_id',
            'project_details',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );

        // creates index for column `customer_id`
        $this->createIndex(
            'idx-project_details-customer_id',
            'project_details',
            'customer_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-project_details-customer_id',
            'project_details',
            'customer_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `installer_id`
        $this->createIndex(
            'idx-project_details-installer_id',
            'project_details',
            'installer_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-project_details-installer_id',
            'project_details',
            'installer_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `project`
        $this->dropForeignKey(
            'fk-project_details-project_id',
            'project_details'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            'idx-project_details-project_id',
            'project_details'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-project_details-customer_id',
            'project_details'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            'idx-project_details-customer_id',
            'project_details'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-project_details-installer_id',
            'project_details'
        );

        // drops index for column `installer_id`
        $this->dropIndex(
            'idx-project_details-installer_id',
            'project_details'
        );

        $this->dropTable('project_details');
    }
}
