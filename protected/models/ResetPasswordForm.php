<?php

class ResetPasswordForm extends CFormModel
{
    public $password;
    public $passwordConfirm;
    
    public function rules()
    {
        return array(array('passwordConfirm',
            'compare',
            'compareAttribute' => 'password',
            'message' => 'Retype password is incorrect.',
        ));
    }

}
?>
