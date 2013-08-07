<?php

class InviteController extends Controller
{

    public function actions()
    {
        return array(
            array(
                'allow',
                'actions' => array('addpeople', 'getInvited'),
                'users' => array('@'),
            ),);
    }

    public function actionAddpeople()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }
        $poll = Poll::model()->findByPk($_POST['invite']['poll_id']);
        $user_id = $this->current_user->id;
        if (isset($_POST['invite']) 
            && $user_id == $poll->user_id 
            && $user_id == $_POST['invite']['sender_id']
        ) {
            $invitation = new Invitation;
            $invitation->attributes = $_POST['invite'];
            if ($invitation->save()) {
                echo header('HTTP/1.1 200 OK');
            } else {
                echo header('HTTP/1.1 405 Method Not Allowed');
            }
        }
    }
    
    public function actionGetInvited() {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }
        if (isset($_POST['poll_id']) && isset($_POST['current_time'])) {
            $users_invited = User::model()->invitedTo($_POST['poll_id'], $this->current_user->id, $_POST['current_time'])->findAll();
            $data = array();
            foreach ($users_invited as $user) {
                $data[] = $user->getData();
            }
            echo json_encode($data);
        } else {
            echo header('HTTP/1.1 405 Method Not Allowed');
        }
        
    }

}

?>
