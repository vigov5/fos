<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $poll_id
 * @property integer $viewed
 * @property string $created_at
 * @property string $updated_at
 */
class Notification extends ActiveRecord
{
    const NOT_VIEWED = 0;
    const VIEWED = 1;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Notification the static model class
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
        return 'notifications';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sender_id, receiver_id, poll_id, viewed', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sender_id, receiver_id, poll_id, viewed, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
            'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
            'receiver' => array(self::BELONGS_TO, 'User', 'receiver_id'),
            'notify_activities' => array(self::HAS_MANY, 'NotifyActivity', 'notification_id'),
            'activities'=>array(self::HAS_MANY, 'Activity', array('activity_id' => 'id'), 'through' => 'notify_activities'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sender_id' => 'Sender',
            'receiver_id' => 'Receiver',
            'poll_id' => 'Poll',
            'viewed' => 'Viewed',
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
        $criteria->compare('sender_id', $this->sender_id);
        $criteria->compare('receiver_id', $this->receiver_id);
        $criteria->compare('poll_id', $this->poll_id);
        $criteria->compare('viewed', $this->viewed);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getNotifyReceiverIDs($params){
        $receivers = array(Poll::model()->findByPk($params['poll_id'])->user_id);
        if (isset($params['target_user_id'])) {
            $receivers[] = $params['target_user_id'];
        }
        return $receivers;
    }

    public function getRecentNotification($params){
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'poll_id=:poll_id AND receiver_id=:receiver_id AND viewed=:viewed',
                'params' => array(
                    ':poll_id' => $params['poll_id'],
                    ':receiver_id' => $params['receiver_id'],
                    ':viewed' => Notification::NOT_VIEWED,
                ),
            )
        );
        return $this;
    }

    /**
     * @author Nguyen Anh Tien
     * @param array $params array of addition params for this notification
     */
    public static function create($params){
        $notification = new Notification;
        $notification->attributes = $params;
        $notification->save();
        return $notification->id;
    }

    /**
     * @author Nguyen Anh Tien
     * @return afterSave
     */
    public function afterSave()
    {
        // publish notification
        $connection = new RedisConnection($this->getJSON());
        $connection->publish(array($this->receiver_id));
    }
    
    /**
     * @author Cao Thanh Luc
     * @return afterSave
     */
    public function afterDelete()
    {
        foreach ($this->notify_activities as $notify_activity) {
            $notify_activity->delete();
        }
    }
    /**
     * @author Nguyen Anh Tien
     * @return array data of this notification
     */
    public function getData(){
        $data = $this->attributes;
        return $data;
    }

    /**
     * @author Nguyen Anh Tien
     * @return string json of notification
     */
    public function getJSON(){
        return json_encode(array(
            'msg_type' => 'notification',
            'data' => $this->getData(),
            )
        );
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function scopes(){
        return array(
            'unread' => array(
                'condition' => 'viewed = 0',
            ),
            'recently' => array(
                'limit' => 5,
            )
        );
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false).'.`updated_at` DESC',
        );
    }

}