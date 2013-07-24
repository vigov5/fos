<?php

/**
 * This is the model class for table "votes".
 *
 * The followings are the available columns in table 'votes':
 * @property integer $id
 * @property integer $user_id
 * @property integer $choice_id
 * @property string $created_at
 * @property string $updated_at
 */
class Vote extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Vote the static model class
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
        return 'votes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, choice_id', 'numerical', 'integerOnly' => true),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, choice_id, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'choice' => array(self::BELONGS_TO, 'Choice', 'choice_id'),
            'activities' => array(self::HAS_MANY, 'Activity', 'vote_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'choice_id' => 'Choice',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('choice_id', $this->choice_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     *
     * @param integer $user_id id of user to search
     * @return function scope that search votes is voted by user
     */
    public function votedBy($user_id){
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => 'user_id=:user_id',
                'params' => array(':user_id' => $user_id),
            )
        );
        return $this;
    }

    /**
     * @author Nguyen Anh Tien
     * @param integer $poll_id id of poll to search
     * @return function search votes that have choices belong to poll
     */
    public function belongTo($poll_id){
        $this->getDbCriteria()->mergeWith(
            array(
                'with' => 'choice',
                'condition' => 'choice.poll_id=:poll_id',
                'params' => array(':poll_id' => $poll_id),
            )
        );
        return $this;
    }

    /**
     * @author Nguyen Anh Tien
     * @return function afterSave
     */
    public function afterSave()
    {
        if (isset(Yii::app()->session['vote_type'])) {
            $params = array(
                'type' => Yii::app()->session['vote_type'],
                'user_id' => $this->user_id,
                'poll_id' => Choice::model()->findByPk($this->choice_id)->poll_id,
                'choice_id' => $this->choice_id,
                'vote_id' => $this->id,
            );
            Activity::create($params);
        }
        return parent::afterSave();
    }

}