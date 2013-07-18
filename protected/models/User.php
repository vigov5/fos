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
class User extends CActiveRecord
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
            array('username', 'length', 'max' => 255),
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

}