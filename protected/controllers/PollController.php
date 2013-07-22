<?php

class PollController extends Controller
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('create', 'index', 'view', 'my', 'all'),
                'users' => array('@'),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'expression' => '$user->is_admin'
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @author Nguyen Thi Huyen
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /*
     * @author Nguyen Van Cuong
     * function view detail poll
     */
    public function actionView($id)
    {
        $poll = Poll::model()->findbyAttributes(array('id' => $id));
        $user = $poll->user;
        $choices = $poll->choices;
        $vote = new Vote;
        $comments = $poll->comments;
        $this->render('view', array(
            'poll' => $poll,
            'user' => $user,
            'choices' => $choices,
            'vote' => $vote,
            'comments' => $comments,
        ));
    }
    
    /*
     * @author Nguyen Van Cuong
     */
    public function loadModel($id) //Find Poll where id = $id
    {
        $model = Poll::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /*
     * @author Nguyen Van Cuong
     */
    public function actionDelete($id) //delete Poll where id = $id
    {
        $poll = $this->loadModel($id);
        $poll->delete();
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /*
     *  @author Nguyen Thi Huyen
     */

    public function actionCreate()
    {
        $poll = new Poll;
        if (isset($_POST['Poll'])) {
            $poll->attributes = $_POST['Poll'];
            if ($poll->save()) {
                Yii::app()->user->setFlash('success', 'You created successfully!');
                $this->redirect(array('view', 'id' => $poll->id));
            }
        }

        $this->render('create', array(
            'poll' => $poll,
        ));
    }
    /*
     *  @author Vu Dang Tung
     */

    public function actionAll()
    {
        $criteria = new CDbCriteria();
        $polls = Poll::model()->findAll($criteria);

        $this->render('all', array('polls' => $polls));
    }

    public function actionMy()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('user_id', Yii::app()->user->getId());
        $polls = Poll::model()->findAll($criteria);

        $this->render('my', array('polls' => $polls));
    }

}

?>

