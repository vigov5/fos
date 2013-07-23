<?php

class InviteController extends Controller
{

    public function actions()
    {
        return array(
            array(
                'allow',
                'actions' => array('addpeople', 'removepeople'),
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

    public function actionRemovepeople()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }

        if (isset($_POST['invite']))  {
            $sender_id = $_POST['invite']['sender_id'];
            $receiver_id = $_POST['invite']['receiver_id'];

            $criteria = new CDbCriteria();
            $criteria->condition = 'sender_id=:sender_id AND receiver_id=:receiver_id';
            $criteria->params = array(':sender_id' => $sender_id, ':receiver_id' => $receiver_id);

            $invitation = Invitation::model()->find($criteria);

            if ($invitation->delete()) {
                echo header('HTTP/1.1 200 OK');
            } else {
                echo header('HTTP/1.1 405 Method Not Allowed');
            }
        }
    }

}
?>
