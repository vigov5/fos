<?php

/**
 * This is the model class for table "invitations".
 *
 * The followings are the available columns in table 'invitations':
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $poll_id
 * @property string $created_at
 * @property string $updated_at
 */
class Invitation extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Invitation the static model class
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
        return 'invitations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sender_id, receiver_id, poll_id', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sender_id, receiver_id, poll_id, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
            'receiver' => array(self::BELONGS_TO, 'User', 'receiver_id'),
            'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
            'activities' => array(self::HAS_MANY, 'Activity', 'invitation_id'),
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
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @author Nguyen Anh Tien
     * @return function afterSave
     */
    public function afterSave(){
        if ($this->isNewRecord) {
            $poll = Poll::model()->findByPk($this->poll_id);
            $params = array(
                'type' => Activity::INVITE,
                'user_id' => $this->sender_id,
                'poll_id' => $this->poll_id,
                'target_user_id' => $this->receiver_id,
                'invitation_id' => $this->id,
                'display_type' => $poll->getActivityDisplayType(),
            );
            Activity::create($params);
        }
        return parent::afterSave();
    }
    
    /**
     * @author Vu Dang Tung
     */
    public function showAllInvited($poll_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'poll_id=:poll_id';
        return Invitation::model()->findAll($criteria);   
    }

}