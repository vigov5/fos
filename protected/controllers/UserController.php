<?php

class UserController extends Controller
{

    /**
     *@author Nguyen Van Cuong
     */
    public function actionSignIn()
    {
        // return user to requested url if user already signin
        if (Yii::app()->user->getId()) {
            Yii::app()->request->redirect(Yii::app()->user->returnUrl);
        } else {
            $form = new SigninForm;
            if (isset($_POST['SigninForm'])) {
                $form->attributes = $_POST['SigninForm'];
                if ($form->validate() && $form->login()) {
                    $this->afterSignIn();
                    Yii::app()->request->redirect(Yii::app()->user->returnUrl);
                }
            }
        }
        $this->render('signin', array('form' => $form));
    }

    /*
     * @author Nguyen Van Cuong
     */

    private function afterSignIn()
    {

    }

    /*
     * @author Cuong, Nguyen Anh Tien
     */

    public function actionSignUp()
    {
        // check for email and secret_key
        if (isset($_GET['email']) && isset($_GET['secret_key'])) {
            $profile = Profile::model()->findByAttributes(
                array('email' => $_GET['email'])
            );
            if (   $profile !== null
                && $profile->secret_key != null
                && $profile->secret_key == $_GET['secret_key']
            ) {
                $signup_form = new SignUpForm;
                if (isset($_POST['SignUpForm'])) {
                    $signup_form->attributes = $_POST['SignUpForm'];
                    if ($signup_form->validate()) {
                        // create user
                        $user = new User;
                        $user->attributes = $_POST['SignUpForm'];
                        $user->password = $user->generatePasswordHash($signup_form->password);
                        $user->profile_id = $profile->id;
                        $user->save();
                        $profile->updateKey();
                        // signin user
                        $signin_form = new SigninForm;
                        $signin_form->attributes = $_POST['SignUpForm'];
                        $signin_form->login();
                        $this->redirect(Yii::app()->homeUrl);
                    }
                }
                $this->render('signup', array('form' => $signup_form));
            }
        }
        // on invalid case, redirect to home page
        $this->redirect($this->createUrl('user/signin'));
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function actionSignOut()
    {
        Yii::app()->user->logout();
        Yii::app()->request->redirect($this->createUrl('home/index'));
    }

}

?>