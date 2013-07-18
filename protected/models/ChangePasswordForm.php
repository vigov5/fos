<?php

class ChangePasswordForm extends CFormModel
{

    public $oldPass;
    public $newPass;
    public $passConfirm;

    public function rules()
    {
        return array(
            array('oldPass', 'required', 'message' => 'Old password cannot be blank!'),
            array('newPass', 'required', 'message' => 'New password cannot be blank!'),
            array('newPass', 'length', 'min' => 6),
            array(
                'passConfirm',
                'compare',
                'compareAttribute' => 'newPass',
                'message' => 'Password confirmation is not match.',
            ),
        );
    }

}
?>