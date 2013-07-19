<?php

class ProfileOrUserFinder
{
    public static function findProfile($arg)
    {
        $user = User::model()->findByAttributes(array('username' => $arg));
        if ($user !== null){
            return $user->profile;
        }
        $profile = Profile::model()->findByAttributes(array('employee_code' => $arg));
        if ($profile === null) {
            $profile = Profile::model()->findByAttributes(array('email' => $arg));
        }
        return $profile;
    }
    
    public static function findUser($arg)
    {
        $user = User::model()->findByAttributes(array('username' => $arg));
        if ($user !== null){
            return $user;
        }
        $profile = Profile::model()->findByAttributes(array('employee_code' => $arg));
        if ($profile !== null) {
            $user = $profile->user;
        }
        return $user;
    }
}
?>
