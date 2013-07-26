<?php

/**
 * This is the model class for table "choices".
 *
 * The followings are the available columns in table 'choices':
 * @property integer $id
 * @property integer $poll_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Choice extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Choice the static model class
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
        return 'choices';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('poll_id', 'numerical', 'integerOnly' => true),
            array('content, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, poll_id, content, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'votes' => array(self::HAS_MANY, 'Vote', 'choice_id'),
            'notifications' => array(self::HAS_MANY, 'Notification', 'choice_id'),
            'activities' => array(self::HAS_MANY, 'Activity', 'choice_id'),
            'poll' => array(self::BELONGS_TO, 'Poll', 'poll_id'),
            'activities' =>array(self::HAS_MANY, 'Activity', 'choice_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'poll_id' => 'Poll',
            'content' => 'Content',
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
        $criteria->compare('poll_id', $this->poll_id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * @author Nguyen Van Cuong, Nguyen Thi Huyen
     * after delete choice . Automatic delete vote and activity belong to choice
     */
    public function afterDelete()
    {
        foreach ($this->votes as $vote) {
            $vote->delete();
        }
        
        foreach ($this->activities as $activity) {
            $activity->delete();
        }
       
        return parent::afterDelete();
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function afterSave()
    {
        if ($this->isNewRecord && !isset(Yii::app()->session['poll_creating'])) {
            $params = array(
                'type' => Activity::ADD_CHOICE,
                'choice_id' => $this->id,
                'poll_id' => $this->poll_id,
                'user_id' => $this->poll->user_id,
                'display_type' => $this->poll->getActivityDisplayType(),
            );
            Activity::create($params);
        }
        return parent::afterSave();
    }
}