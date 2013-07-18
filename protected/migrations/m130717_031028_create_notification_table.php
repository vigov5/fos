<?php

class m130717_031028_create_notification_table extends CDbMigration
{

    public function up()
    {
        $transaction = $this->getDbConnection()->beginTransaction();
        try {
            $this->createTable('notifications', array(
                'id' => 'pk AUTO_INCREMENT',
                'sender_id' => 'integer',
                'receiver_id' => 'integer',
                'poll_id' => 'integer',
                'viewed' => 'boolean',
                'type' => 'integer',
                'comment_id' => 'integer',
                'choice_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));
            $transaction->commit();
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            $transaction->rollBack();
            return false;
        }
    }

    public function down()
    {
        try {
            $this->dropTable('notifications');
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
