<?php
/**
 * @author Nguyen Anh Tien
 */
class m130723_062104_create_activities_table extends CDbMigration
{
	public function safeUp()
	{
        try {
            $this->createTable('activities', array(
                'id' => 'pk AUTO_INCREMENT',
                'type' => 'integer',
                'user_id' => 'integer',
                'poll_id' => 'integer',
                'vote_id' => 'integer',
                'invitation_id' => 'integer',
                'comment_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            return false;
        }
	}

	public function safeDown()
	{
        try {
            $this->dropTable('activities');
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            return false;
        }
	}

}
