<?php
/**
 * author Vu Dang Tung
 */
class CommentController extends Controller
{
    public function actions()
    {
        return array(
            array(
                'allow',
                'actions' => array('create, addreply'),
                'users' => array('@'),
            ),);
    }
    
	public function actionCreate()
	{
		if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }
        $comment = new Comment;
        if (isset($_POST['comment_data']) ) {
            $comment->attributes = $_POST['comment_data'];
            $comment->user_id = $this->current_user->id;
            $poll = Poll::model()->findbyPk($_POST['comment_data']['poll_id']);
            $cancomment = $this->current_user->canViewPoll($poll);
            $user = User::model()->findbyPk($this->current_user->id);
            if ($cancomment && $comment->save()) {
              echo json_encode(array (
                  'user_name' => $user->username,
                  'content' => $comment->content,
                  'created_at' => $comment->created_at,
                  'profile_link' => $user->profile->createViewlink(),
              ));
            } else {
                echo header('HTTP/1.1 404 Method Not Allowed');
            } 
        } else {
            echo header('HTTP/1.1 405 Method Not Allowed');
        }   
	}
    
    public function actionAddreply() {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        } 
        $comment = new Comment;
        if (isset($_POST['comment_data']) ) {
            $parent_comment = Comment::model()->findByPk($_POST['comment_data']['parent_id']);
            if ($parent_comment && $parent_comment->canBeReplied()) {
                $comment->attributes = $_POST['comment_data'];
                $comment->user_id = $this->current_user->id;
                $poll = Poll::model()->findbyPk($_POST['comment_data']['poll_id']);
                $cancomment = $this->current_user->canViewPoll($poll);
                $user = User::model()->findbyPk($this->current_user->id);
                if ($cancomment && $comment->save()) {
                  echo json_encode(array (
                      'user_name' => $user->username,
                      'content' => $comment->content,
                      'created_at' => $comment->created_at,
                      'profile_link' => $user->profile->createViewlink(),
                  ));
                } else {
                    echo header('HTTP/1.1 405 Method Not Allowed');
                }
            } else {
                echo header('HTTP/1.1 405 Method Not Allowed');
            }
        } else {
            echo header('HTTP/1.1 405 Method Not Allowed');
        } 
    }
}