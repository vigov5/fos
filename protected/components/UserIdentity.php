<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    /**
     * Authenticates a user.
     * @author Nguyen Anh Tien
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('username' => $this->username));
        if ($user == null) {
            $profile = Profile::model()->findByAttributes(array('employee_code' => $this->username));
            if ($profile == null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $user = $profile->user;
            }
        }
        if ($user !== null) {
            if ($user->isValidPassword($this->password)) {
                $this->_id = $user->id;
                $this->setState('username', $user->username);
                $this->setState('profileId', $user->profile_id);
                if ($user->is_admin) {
                    $this->setState('isAdmin', true);
                } else {
                    $this->setState('isAdmin', false);
                }
                $this->errorCode = self::ERROR_NONE;
            } else {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
        }
        return !$this->errorCode;
    }
    /**
     * @author Nguyen Anh Tien
     * @return integer id of current signin user
     */
    public function getId()
    {
        return $this->_id;
    }

}