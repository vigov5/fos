<?php

class m130730_081039_create_notify_activity_join_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        try {
            $this->createTable('notify_activities', array(
                'id' => 'pk AUTO_INCREMENT',
                'notification_id' => 'integer',
                'activity_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));
            $this->dropColumn('activities', 'notification_id');
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            return false;
        }
	}

	public function safeDown()
	{
        try {
            $this->dropTable('notify_activities');
            $this->addColumn('activities', 'notification_id', 'integer');
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            return false;
        }
	}

}