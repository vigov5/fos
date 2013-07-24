<?php

class m130724_071911_add_columns_to_table_activities extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn('activities', 'display_type', 'integer');
        $this->addColumn('activities', 'choice_id', 'integer');
        $this->addColumn('activities', 'target_user_id', 'integer');
	}

	public function safeDown()
	{
        $this->dropColumn('activities', 'display_type');
        $this->dropColumn('activities', 'choice_id');
        $this->dropColumn('activities', 'target_user_id');
	}

}