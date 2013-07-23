<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    /**
     *
     * @var array All activities detail
     */
    public $stream = array();
    
    /**
     *
     * @var User current logging in user
     */
    public $current_user;

    /**
     * If user logged in then get all recent activities detail and add to stream array
     * @param string $action     
     * @author Tran Duc Thang
     */   
    public function beforeAction($action)
    {
        if (!Yii::app()->user->isGuest) {
            $this->current_user = clone Yii::app()->session['current_user'];
            $this->stream[] = 'test 1';
            $this->stream[] = 'test 2';
            $this->stream[] = 'test 3';
        }
        return parent::beforeAction($action);
    }

}