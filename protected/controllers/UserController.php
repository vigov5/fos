<?php
class UserController extends Controller
{
    /**
     *@author Cuong
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
        $this->render('signin', array('form' => $form ));
    }
    /* 
     *@author Cuong  
     */
    private function afterSignIn()
    {
        
    }
    /*
     * @author Cuong
     */
    public function actionSignUp()
    {
        $form = new SignUpForm; 
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