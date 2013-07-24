<?php

class InviteController extends Controller
{

    public function actions()
    {
        return array(
            array(
                'allow',
                'actions' => array('addpeople'),
                'users' => array('@'),
            ),);
    }

    public function actionAddpeople()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }

        if (isset($_POST['invite'])) {
            $invitation = new Invitation;
            $invitation->attributes = $_POST['invite'];
            if ($invitation->save()) {
                echo header('HTTP/1.1 200 OK');
            } else {
                echo header('HTTP/1.1 405 Method Not Allowed');
            }
        }
    }

}

?>
