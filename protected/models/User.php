<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $profile_id
 * @property integer $is_admin
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('profile_id, is_admin', 'numerical', 'integerOnly' => true),
            array('username', 'unique'),
            array('username', 'unique', 'className' => 'Profile', 'attributeName' => 'employee_code'),
            array('username', 'length', 'max' => 20),
            array('password, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, profile_id, is_admin, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'profile' => array(self::BELONGS_TO, 'Profile', 'profile_id'),
            'polls' => array(self::HAS_MANY, 'Poll', 'user_id'),
            'votes' => array(self::HAS_MANY, 'Vote', 'user_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
            'notifications_sent' => array(self::HAS_MANY, 'Notification', 'sender_id'),
            'notifications_received' => array(self::HAS_MANY, 'Notification', 'receiver_id'),
            'invitations_sent' => array(self::HAS_MANY, 'Invitation', 'sender_id'),
            'invitations_received' => array(self::HAS_MANY, 'Invitation', 'receiver_id'),
            'activities' => array(self::HAS_MANY, 'Activity', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'profile_id' => 'Profile',
            'is_admin' => 'Is Admin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('profile_id', $this->profile_id);
        $criteria->compare('is_admin', $this->is_admin);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @author Nguyen Anh Tien
     * @return string hashed password
     */
    public function generatePasswordHash($raw_password)
    {
        return crypt($raw_password, Randomness::blowfishSalt());
    }

    /**
     * @author Nguyen Anh Tien
     * @param string input password
     * @return boolean whether password is valid or not
     */
    public function isValidPassword($raw_password)
    {
        return crypt($raw_password, $this->password) === $this->password;
    }

    public function deleteAllVote($poll_id)
    {
        foreach ($this->getAllVotes($poll_id) as $vote) {
            $vote->delete();
        }
    }

    public function getAllVotes($poll_id)
    {
        return Vote::model()->votedBy($this->id)->belongTo($poll_id)->findAll();
    }

    public function getRecentNotifications($last_id, $limit = 10)
    {
        if ($last_id == 'undefined') {
            $condition = "receiver_id = {$this->id}";
        } else {
            $condition = "receiver_id = {$this->id} AND id < {$last_id}";
        }
        return Notification::model()->findAll(
            array(
                'condition' => $condition,
                'limit' => $limit,
            )
        );
    }

    public function afterDelete()
    {
        foreach ($this->polls as $poll) {
            $poll->delete();
        }

        foreach ($this->activities as $activity) {
            $activity->delete();
        }

        foreach ($this->invitations_sent as $invitation) {
            $invitation->delete();
        }

        foreach ($this->invitations_received as $invitation) {
            $invitation->delete();
        }

        foreach ($this->notifications_sent as $notification) {
            $notification->delete();
        }

        foreach ($this->notifications_received as $notification) {
            $notification->delete();
        }

        return parent::afterDelete();
    }

    /*
     * @author Cao Thanh Luc
     * can view display setting
     */

    public function canViewPoll($poll)
    {
        $invited = false;
        $invitations = $poll->invitations;
        foreach ($invitations as $invi) {
            if ($invi->receiver->id == $this->id) {
                $invited = true;
                break;
            }
        }
        if ($poll->user_id == $this->id || $poll->display_type == 1 || $poll->display_type == 2 || $invited) {
            return true;
        } else {
            return false;
        }
    }

    public function canVotePoll($poll)
    {
        $invited = false;
        $invitations = $poll->invitations;
        foreach ($invitations as $invi) {
            if ($invi->receiver->id == $this->id) {
                $invited = true;
                break;
            }
        }
        if ($poll->user_id == $this->id || $poll->display_type == 1 || $invited) {
            return true;
        } else {
            return false;
        }
    }

    public function notInvitedTo($poll_id, $user_id)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'id not in (select receiver_id from invitations where poll_id=:poll_id)
                AND id !=:user_id',
                'params' => array('poll_id' => $poll_id, ':user_id' => $user_id),
            )
        );
        return $this;
    }

    /**
     *
     * @author Vu Dang Tung
     * @param integer $poll_id The id of the poll
     * @param integer $user_id The id of the user
     * @return list all user invited in this poll
     */
    public function invitedTo($poll_id, $user_id)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'id in (select receiver_id from invitations where poll_id=:poll_id)
                AND id !=:user_id',
                'params' => array('poll_id' => $poll_id, ':user_id' => $user_id),
            )
        );
        return $this;
    }

    public function getAllVisibleActivitesOfUser($user_id)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'user_id=:target_user_id',
                'params' => array('target_user_id' => $user_id),
            )
        );
        return Activity::model()->allVisibleActivitiesNotInclude($this->id, false);
    }

     /**
     * @author Pham Tri Thai
     * return view vorter permission
     */
    public function canViewVoter ($poll)
    {
        if ($poll->poll_type == Poll::POLL_TYPE_SETTINGS_ANONYMOUS) {
            return false;
        } else {
            if ($poll->result_detail_type == Poll::RESULT_DETAIL_SETTINGS_ALL
                || $poll->user_id == $this->id) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @author Pham Tri Thai
     * check user is voted?
     */
    public function checkVoted($poll_id) {
        if (Vote::model()->votedBy($this->id)->belongTo($poll_id)->find()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @author Pham Tri Thai
     * return view result permission
     */
    public function canViewResult ($poll)
    {
        $start_at = strtotime($poll->start_at);
        $end_at = strtotime($poll->end_at);
        $current_time = time();
        if ($current_time >= $start_at && $current_time <= $end_at) {
            $votting = true;
        } else {
            $votting = false;
        }

        $show_result = false;

        if ($poll->user_id == $this->id) {
            $show_result = true;
        } elseif ($poll->result_show_time_type == Poll::RESULT_TIME_SETTINGS_AFTER && $votting) {
            $show_result = false;
        } else {
            switch ($poll->result_display_type) {
                case Poll::RESULT_DISPLAY_SETTINGS_PUBLIC:
                    $show_result = true;
                    break;
                case Poll::RESULT_DISPLAY_SETTINGS_VOTED_ONLY:
                    // check this user is voter
                    if ($this->checkVoted($poll->id)) {
                        $show_result = true;
                    }
                    break;
            }
        }
        return $show_result;
    }

    /**
     * @author Nguyen Anh Tien
     * @param Activity a restricted activity
     * @return array list of user_id that can view this activity
     */
    public function listUsersCanViewRestrictedActivity($activity){
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'id in (select receiver_id from invitations where poll_id=:poll_id)',
                'params' => array(
                    ':poll_id' => $activity->poll_id,
                ),
            )
        );
        return $this;
    }

    /**
     * @author Nguyen Anh Tien
     * @return integer number of unread notifications
     */
    public function getUnreadNotify(){
        return count($this->notifications_received('notifications_received:unread'));
    }
}