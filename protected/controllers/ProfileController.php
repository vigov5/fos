<?php

class ProfileController extends Controller
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'profile' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $profile = new Profile;
        if (isset($_POST['Profile'])) {
            $profile->attributes = $_POST['Profile'];
            if ($profile->save())
                $this->redirect(array('view', 'id' => $profile->id));
        }

        $this->render('create', array(
            'profile' => $profile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $profile = $this->loadModel($id);
        if (isset($_POST['Profile'])) {
            $profile->attributes = $_POST['Profile'];
            if ($profile->save())
                $this->redirect(array('view', 'id' => $profile->id));
        }

        $this->render('update', array(
            'profile' => $profile,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Profile the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $profile = Profile::model()->findByPk($id);
        if ($profile === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $profile;
    }

}