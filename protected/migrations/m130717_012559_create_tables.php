<?php

class m130717_012559_create_tables extends CDbMigration
{

    public function up()
    {
        $transaction = $this->getDbConnection()->beginTransaction();
        try {
            $this->createTable('users', array(
                'id' => 'pk AUTO_INCREMENT',
                'username' => 'string',
                'password' => 'text',
                'profile_id' => 'integer',
                'is_admin' => 'boolean',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));

            $this->createTable('polls', array(
                'id' => 'pk AUTO_INCREMENT',
                'question' => 'string',
                'description' => 'text',
                'user_id' => 'integer',
                'is_multichoice' => 'boolean',
                'poll_type' => 'integer',
                'display_type' => 'integer',
                'result_display_type' => 'integer',
                'result_detail_type' => 'integer',
                'result_show_time_type' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
                'start_at' => 'datetime',
                'end_at' => 'datetime',
            ));

            $this->createTable('choices', array(
                'id' => 'pk AUTO_INCREMENT',
                'poll_id' => 'integer',
                'content' => 'text',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));

            $this->createTable('votes', array(
                'id' => 'pk AUTO_INCREMENT',
                'user_id' => 'integer',
                'choice_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));

            $this->createTable('comments', array(
                'id' => 'pk AUTO_INCREMENT',
                'content' => 'text',
                'user_id' => 'integer',
                'poll_id' => 'integer',
                'parent_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));

            $this->createTable('invitations', array(
                'id' => 'pk AUTO_INCREMENT',
                'sender_id' => 'integer',
                'receiver_id' => 'integer',
                'poll_id' => 'integer',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ));

            $this->createTable('profiles', array(
                'id' => 'pk AUTO_INCREMENT',
                'email' => 'string',
                'name' => 'string',
                'phone' => 'string',
                'address' => 'text',
                'employee_code' => 'string',
                'secret_key' => 'string',
                'position' => 'string',
                'date_of_birth' => 'date',
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
            $this->dropTable('users');
            $this->dropTable('polls');
            $this->dropTable('votes');
            $this->dropTable('comments');
            $this->dropTable('choices');
            $this->dropTable('invitations');
            $this->dropTable('profiles');
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
