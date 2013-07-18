<?php

class SignUpForm extends User
{
    public $password;
    public $passwordConfirm;    

    /*
     * @author Nguyen Van Cuong
     * rule of state that passwordconfirm is required 
     * password and password confirm will be compare
     */
    public function rules() {
        $rules = parent::rules();               
        $rules[] = array('passwordConfirm', 'required');
        $rules[] = array('password', 'compare',
            'compareAttribute' => 'passwordConfirm',
            'message' => 'Retype password is incorrect.');        
        return $rules;
    }
}

?>