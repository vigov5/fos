<?php

class m130729_095751_change_struct_notification_n_activity_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn('activities', 'notification_id', 'integer');
        $this->dropColumn('notifications', 'choice_id');
        $this->dropColumn('notifications', 'comment_id');
        $this->dropColumn('notifications', 'type');
	}

	public function safeDown()
	{
        $this->dropColumn('activities', 'notification_id');
        $this->addColumn('notifications', 'choice_id', 'integer');
        $this->addColumn('notifications', 'comment_id', 'integer');
        $this->addColumn('notifications', 'type', 'integer');
	}
}