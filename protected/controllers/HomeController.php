<?php

class HomeController extends Controller
{

    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "user_id = {$this->current_user->id}";
        $total = Activity::model()->count($criteria);
        $pages = new CPagination($total);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $activities = Activity::model()->findAll($criteria);
        $this->render('index', array(
            'activities' => $activities,
            'pages' => $pages,
        ));
    }

}
?>
