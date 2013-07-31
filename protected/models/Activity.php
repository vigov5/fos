<?php

/**
 * This is the model class for table "activities".
 *
 * The followings are the available columns in table 'activities':
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property integer $poll_id
 * @property integer $vote_id
 * @property integer $display_type
 * @property integer $target_user_id
 * @property integer $invitation_id
 * @property integer $comment_id
 * @property string $created_at
 * @property string $updated_at
 */
class Activity extends ActiveRecord
{

    const CREATE_POLL = 1;
    const ADD_CHOICE = 2;
    const CHANGE_POLL_TIME = 3;
    const CHANGE_POLL_SETTING = 4;
    const VOTE = 5;
    const RE_VOTE = 6;
    const INVITE = 7;
    const COMMENT = 8;
    const REPLY_COMMENT = 9;
    const DISPLAY_PUBLIC = 1;
    const DISPLAY_PRIVATE = 2;
    const DISPLAY_RESTRICTED = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Activity the static model class
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
        return 'activities';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, user_id, poll_id, vote_id, invitation_id, comment_id, display_type, choice_id, target_user_id', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, user_id, poll_id, vote_id, invitation_id, comment_id, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'target_user' => array(self::BELONGS_TO, 'User', 'target_user_id'),
            'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
            'vote' => array(self::BELONGS_TO, 'Vote', 'vote_id'),
            'choice' => array(self::BELONGS_TO, 'Choice', 'choice_id'),
            'invitation' => array(self::BELONGS_TO, 'Invitation', 'invitation_id'),
            'notify_activities' => array(self::HAS_MANY, 'NotifyActivity', 'activity_id'),
            'notifications'=>array(self::HAS_MANY, 'Notification', array('notification_id' => 'id'), 'through' => 'notifiy_activities'),
            'comment' => array(self::BELONGS_TO, 'Comment', 'comment_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User',
            'target_user_id' => 'Target User',
            'poll_id' => 'Poll',
            'vote_id' => 'Vote',
            'invitation_id' => 'Invitation',
            'comment_id' => 'Comment',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('poll_id', $this->poll_id);
        $criteria->compare('vote_id', $this->vote_id);
        $criteria->compare('invitation_id', $this->invitation_id);
        $criteria->compare('notification_id', $this->notification_id);
        $criteria->compare('comment_id', $this->comment_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @author Nguyen Anh Tien
     * @param array $params array of addition params for this activity
     */
    public static function create($params)
    {
        $notify_receiver_ids = Notification::getNotifyReceiverIDs($params);
        foreach ($notify_receiver_ids  as $receiver_id) {
            $params['receiver_id'] = $receiver_id;
            $recent_notification = Notification::model()->getRecentNotification($params)->find();
            if (!$recent_notification) {
                // create new notification
                $poll_owner_id = Poll::model()->findByPk($params['poll_id'])->user_id;
                $notify_params = array(
                        'poll_id' => $params['poll_id'],
                        'sender_id' => $params['user_id'],
                        'receiver_id' => $params['receiver_id'],
                        'viewed' => 0,
                );
                $notify_id = Notification::create($notify_params);
                $activity_id = Activity::_createActivity($params);
                NotifyActivity::create($activity_id, $notify_id);
            } else {
                $activity_id = Activity::_createActivity($params);
                NotifyActivity::create($activity_id, $recent_notification->id);
            }
        }
    }

    /**
     * @author Nguyen Anh Tien
     * @param array $params array of addition params for this activity
     * @return integer newly created activity
     */
   private static function _createActivity($params){
        $activity = new Activity;
        $activity->attributes = $params;
        $activity->save();
        return $activity->id;
   }

    /**
     * @author Nguyen Anh Tien
     */
    public function defaultScope()
    {
        return array(
            'order' => "id DESC",
        );
    }

    /**
     * @author Nguyen Anh Tien
     * @param User current user
     */
    public function allVisibleActivitiesNotInclude($user_id)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'display_type=:public AND user_id!=:user_id',
                //  params :public and :user_id in condition
                'params' => array(
                    ':public' => Activity::DISPLAY_PUBLIC,
                    ':user_id' => $user_id,
                ),
            )
        );
        $this->getDbCriteria()->mergeWith(
            array(
            'condition' => 'display_type=:invited AND poll_id in (select poll_id from invitations where receiver_id=:user_id)',
            'params' => array(
                ':user_id' => $user_id,
                ':invited' => Activity::DISPLAY_RESTRICTED,
            ),
            ), 'OR'
        );

        return $this;
    }

    /*
     * @author Nguyen Van Cuong
     * scope limit , non condition
     */

    public function recently($limit = 10)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'limit' => $limit,
            )
        );
        return $this;
    }

    /*
     * @author Nguyen Van Cuong
     * scope offset
     */

    public function offset($index = 0)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'offset' => $index,
            )
        );
        return $this;
    }

    /**
     * @author Nguyen Anh Tien
     * @return string json of activity
     */
    public function getJSON($current_user_id = null)
    {
        return json_encode(array(
                'msg_type' => 'stream',
                'data' => $this->getData($current_user_id),
            )
        );
    }

    /**
     * @author Nguyen Anh Tien
     * @param integer current_user_id
     * @return array data of this activity
     */
    public function getData($current_user_id){
        $data = $this->attributes;
        $data['profile_id'] = $this->user->profile_id;
        $data['target_profile_id'] = $this->target_user_id ? $this->target_user->profile_id : null;
        $data['poll_question'] = $this->poll->question;
        $data['choice_content'] = $this->choice_id ? $this->choice->content : null;
        $data['profile_name'] = $this->user->profile->name;
        $data['target_profile_name'] = $this->target_user_id ? $this->target_user->profile->name : null;
        $data['created_at'] = DateAndTime::humanReadableTime($data['created_at']);
        if ($data['user_id'] == $current_user_id) {
            $data['is_correct_user'] = true;
        } else {
            $data['is_correct_user'] = false;
        }
        unset($data['target_user_id']);
        unset($data['user_id']);
        unset($data['display_type']);
        return $data;
    }

    /**
     * @author Nguyen Anh Tien
     * @return array array of subscribers's id
     */
    public function getSubscriberIDs()
    {
        if ($this->display_type == Activity::DISPLAY_PRIVATE) {
            return array();
        } else if ($this->display_type == Activity::DISPLAY_RESTRICTED) {
            return User::model()->listUsersCanViewRestrictedActivity($this)->selectID()->findAll(
                    'id!=:user_id', array(':user_id' => $this->user_id)
            );
        } else {
            return User::model()->selectID()->findAll(
                    'id!=:user_id', array(':user_id' => $this->user_id)
            );
        }
    }

    /**
     * @author Nguyen Anh Tien
     * @return afterSave
     */
    public function afterSave()
    {
        // publish activity
        $subscribers = CHtml::listData($this->getSubscriberIDs(), 'id', 'id');
        $subscribers = array_keys($subscribers);
        $connection = new RedisConnection($this->getJSON());
        $connection->publish($subscribers);
        return parent::afterSave();
    }

}

