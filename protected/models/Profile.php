<?php

/**
 * This is the model class for table "profiles".
 *
 * The followings are the available columns in table 'profiles':
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $employee_code
 * @property string $secret_key
 * @property string $position
 * @property string $date_of_birth
 * @property string $created_at
 * @property string $updated_at
 */
class Profile extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Profile the static model class
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
        return 'profiles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, name, phone, employee_code, secret_key, position', 'length', 'max' => 255),
            array('address, date_of_birth, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, name, phone, address, employee_code, secret_key, position, date_of_birth, created_at, updated_at', 'safe', 'on' => 'search'),
            array('email, employee_code, name', 'required'),
            array('email', 'email'),
            array('date_of_birth', 'date', 'format' => 'yyyy-M-d'),
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
            'user' => array(self::HAS_ONE, 'User', 'profile_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'employee_code' => 'Employee Code',
            'secret_key' => 'Secret Key',
            'position' => 'Position',
            'date_of_birth' => 'Date Of Birth',
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
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('employee_code', $this->employee_code, true);
        $criteria->compare('secret_key', $this->secret_key, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @author Nguyen Anh Tien
     * @return string signup URL
     */
    public function generateSignUpLink()
    {
        if ($this->secret_key == null) {
            $this->updateKey();
        }
        return Yii::app()->createAbsoluteUrl(
            'user/signup', array('email' => $this->email, 'secret_key' => $this->secret_key)
        );
    }

    /**
     * @author Pham Tri Thai
     * @return string reset password URL
     */
    public function generateResetPasswordLink()
    {
        return Yii::app()->createAbsoluteUrl(
            'user/resetPassword', array(
                'email' => $this->email,
                'key' => $this->secret_key
            )
        );
    }

    /**
     * @author Nguyen Anh Tien
     * @return string unique string used as secret_key
     */
    private function generateKey()
    {
        $key = '';
        for ($i = 0; $i < 100; $i++) {
            $salt = uniqid(mt_rand(0, microtime(true)), true);
            $key = sha1($key . $salt);
        }
        return $key;
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function updateKey()
    {
        $this->secret_key = $this->generateKey();
        $this->save();
    }
    

    /*
     * @author Vu Dang Tung
     */

    public function sendResetPasswordLink()
    {
        $link = $this->generateResetPasswordLink();
        $result = MailSender::sendMail('Reset Password', $this->email, $this->name, $link);
        return $result;
    }

     public function deleteUser()
    {
        $user = $this->user;
        $user->delete();
    }
    /*
     * @author Vu Dang Tung
     * send user link to sign up task#5309
     */
    public function sendSignUpEmail()
    {   
        $link = $this->generateSignUpLink();
        $result = MailSender::sendMail('Sign Up Link', $this->email, $this->name, $link);
        return $result;
    }
}

