<?php
class UserController extends Controller
{
    /**
     *@author Cuong
     */
    public function actionSignIn()
    {
        $form = new SigninForm;
        if (isset($_POST['SigninForm']))
        {
            $form->attributes = $_POST['SigninForm'];
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
}
?>