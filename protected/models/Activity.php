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
     * @return boolean
     */
    public static function create($params){
        $activity = new Activity;
        $activity->attributes = $params;
        $activity->save();
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function defaultScope()
    {
        return array(
            'order'=>"updated_at DESC",
        );
    }

    /**
     * @author Nguyen Anh Tien
     * @param User current user
     */
    public function allActivitiesNotInclude($user){
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'display_type=:public AND user_id!=:user_id',
                'params' => array(
                    ':public' => Activity::DISPLAY_PUBLIC,
                    ':user_id' => $user->id,
                ),
            )
        );
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'display_type=:invited AND poll_id in (select poll_id from invitations where receiver_id=:user_id)',
                'params' => array(
                    ':user_id' => $user->id,
                    ':invited' => Activity::DISPLAY_RESTRICTED,
                ),
            ),
            'OR'
        );

        return $this;
    }

}