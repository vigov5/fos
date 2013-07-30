<?php

class ActivityController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
    
    public function actionLoadMore()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('/site/error', array('code' => 403, 'message' => 'Forbidden'));
            Yii::app()->end();
        }
        if (isset($_POST['activity_id']) && isset($_POST['profile_id'])) {
            $profile = Profile::model()->findByPk($_POST['profile_id']);
            if (isset($profile->user)) {
                $criteria = new CDbCriteria;
                $criteria->condition = "id < {$_POST['activity_id']}";
                $criteria->limit = 10;
                if ($profile->user->id === $this->current_user->id){
                    $criteria->condition .= " AND user_id = {$this->current_user->id}";
                    $activities = Activity::model()->findAll($criteria);
                } else {
                    $user = User::model()->findByPk($this->current_user->id);
                    $activities = $user->getAllVisibleActivitesOfUser($profile->user->id)->findAll($criteria);
                }
            } else {
                $activities = array();
            }
            if (!empty($activities)) {
                $result = array();
                foreach($activities as $activity) {
                    $result[] = $activity->getJSON($this->current_user->id);
                }
                echo json_encode($result);
            } else {
                echo json_encode(array());
            }
        }
    }
}