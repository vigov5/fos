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
                'actions' => array('create'),
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
            if ($comment->save()) {
              echo json_encode($comment->id);
            } else {
                echo header('HTTP/1.1 405 Method Not Allowed');
            } 
        } else {
            echo header('HTTP/1.1 405 Method Not Allowed');
        }   
	}
}