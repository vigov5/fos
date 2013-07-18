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
            if (isset($_POST['SigninForm']))
            {
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
     * @author Nguyen Van Cuong
     */

    public function actionSignUp()
    {
        $form = new SignUpForm;
        if (isset($_POST['SignUpForm'])) {
            $form->attributes = $_POST['SignUpForm'];
        }
        $this->render('signup', array('form' => $form));
    }

    /**
     * @author Nguyen Anh Tien
     */
    public function actionSignOut(){
        Yii::app()->user->logout();
        Yii::app()->request->redirect($this->createUrl('home/index'));
    }
}
?>