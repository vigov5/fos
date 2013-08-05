<?php

class SearchController extends Controller {
    
    public function actionIndex($key_word) {
        $profile = Profile::model()->find(
            'employee_code=:employee_code OR name = :name', 
            array(':employee_code' => $key_word, ':name' => $key_word)
        );
        if (isset($profile)) {
            $this->redirect(array('profile/view', 'id' => $profile->id));
        }
        
        $polls = Poll::model()->findAll();
        $as = new ApproximateSearch($polls, array('question', 'description') , $key_word);
        $polls_found = $as->search();
        
        $profiles = Profile::model()->findAll();
        $as = new ApproximateSearch($profiles, array('name'), $key_word);
        $profiles_found = $as->search();
        $this->render('results', array(
            'polls_found' => $polls_found,
            'profiles_found' => $profiles_found,
            'key_word' => $key_word,
        ));
    }
}

?>