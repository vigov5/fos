<?php

class PollController extends Controller
{

    public function actionIndex()
    {
        $this->render('index');
    }

    /*
     * @author Nguyen Van Cuong
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

}

?>
