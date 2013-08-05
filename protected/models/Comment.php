<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property integer $poll_id
 * @property integer $parent_id
 * @property string $created_at
 * @property string $updated_at
 */
class Comment extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comment the static model class
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
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, poll_id, parent_id', 'numerical', 'integerOnly' => true),
            array('content, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, user_id, poll_id, parent_id, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'parent' => array(self::BELONGS_TO, 'Comment', 'parent_id'),
            'children' => array(self::HAS_MANY, 'Comment', 'parent_id'),
            'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
            'activities' => array(self::HAS_MANY, 'Activity', 'comment_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Content',
            'user_id' => 'User',
            'poll_id' => 'Poll',
            'parent_id' => 'Parent',
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
        $criteria->compare('content', $this->content, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('poll_id', $this->poll_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function canBeReplied() {
        if ($this->parent_id) {
            return false;
        }
        return true;
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            $params = array(
                'type' => ($this->parent_id ? Activity::REPLY_COMMENT : Activity::COMMENT),
                'user_id' => $this->user_id,
                'poll_id' => $this->poll_id,
                'comment_id' => $this->id,
                'display_type' => $this->poll->getActivityDisplayType(),
            );
            Activity::create($params);
        }
        return parent::afterSave();
    }

    public function scopes() {
        return array(
            'is_parent' => array(
                'condition' => 'parent_id is NULL',
            ),
            'limit_comment' => array(
                'limit' => 5,
            ),
            'order_created_at' => array(
                'order' => 'created_at DESC',
            ),
        );
    }

    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false).'.`id` DESC',
        );
    }

    public function getData(){
        $data = $this->attributes;
        $data['profile_name'] = $this->user->profile->name;
        $data['profile_id'] = $this->user->profile_id;
        $data['children_comments_count'] = count($this->children);
        return $data;
    }
}