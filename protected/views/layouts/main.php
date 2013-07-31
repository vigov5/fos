<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ejs/ejs_production.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/baseJS.js');

        Yii::app()->bootstrap->register();
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/datetimepicker.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-bubble-popup-v3.css');

        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui.js');        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/stream_scroll.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-bubble-popup-v3.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/main.js');
       ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="row-fluid" id="page">
            <div id="mainmenu">
                <?php
                if (Yii::app()->user->isGuest) {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'type' => 'inverse', // null or 'inverse'
                        'brand' => 'framgia',
                        'brandUrl' => '#',
                        'collapse' => true, // requires bootstrap-responsive.css
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                            ),
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'items' => array(
                                    array('label' => 'Sign In', 'icon' => 'user white',
                                        'url' => array('user/signin')
                                    ),
                                ),
                            ),
                        ),
                    ));
                } else {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'type' => 'inverse', // null or 'inverse'
                        'brand' => 'framgia',
                        'brandUrl' => '#',
                        'collapse' => true, // requires bootstrap-responsive.css
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'home-menu'),
                                'items' => array(
                                    array(
                                        'label' => 'Home',
                                        'icon' => 'home white',
                                        'url' => array('profile/view', 'id' => Yii::app()->user->profile_id),
                                    ),                                    
                                ),
                            ),
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'notification-menu'),
                                'items' => array(                                    
                                    array(                                        
                                        'label' => 'Notifications',
                                        'icon' => 'globe white',
                                        'url' => '#',
                                    ),
                                ),
                            ),
                            '<form class="navbar-search pull-left" action=""><input type="text"
                             class="search-query" placeholder="search people, post and anythings">
                            </form>',
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'items' => array(
                                    array('label' => 'Profiles', 'url' => array('profile/index')),
                                    array('label' => 'All Polls', 'url' => array('poll/index')),
                                    array('label' => 'My Polls', 'url' => array('poll/my')),
                                    array('label' => Yii::app()->user->username, 'icon' => 'user white', 'url' => '#',
                                        'items' => array(
                                            array(
                                                'label' => 'Change password',
                                                'icon' => 'cog',
                                                'url' => array('user/changePassword'),
                                            ),
                                            array('label' => 'Help', 'icon' => 'flag', 'url' => '#'),
                                            '---',
                                            array('label' => 'Logout', 'icon' => 'icon-share', 'url' => array('user/signout')),
                                        )),
                                ),
                            ),
                        ),
                    ));
                }
                ?>
            </div>
            <div class="row-fluid main-page">
                <?php
                if (Yii::app()->user->isGuest) {
                    echo '<div class="clear"></div>';
                    echo $content;
                } else {
                    ?>
                    <div class="span9 content" id="main-content">
                        <?php echo $content; ?>
                    </div>
                    <div class="span3 stream" id="stream">
                        <?php
                        foreach ($this->stream as $activity) {
                            $this->renderPartial(
                                '/stream/_an_activity', array('activity' => $activity)
                            );
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div><!-- page -->
        <script src='<?php echo Yii::app()->baseUrl; ?>/js/socket.io.min.js'></script>
        <script src='<?php echo Yii::app()->baseUrl; ?>/js/client.js'></script>
        <?php
            if (!Yii::app()->user->isGuest) {
        ?>
                <script>
                    $(function(){
                        socket_client = new SocketClient("<?php echo Yii::app()->user->getState('RedisChannel') ?>");
                    });
                    var notify_num = 0;
                    var stream_id_global = <?php
                        if (!empty($this->stream)) {
                            echo end($this->stream)->id;
                        } else {
                            echo 0;
                        }
                    ?>;
                </script>
        <?php
            }
        ?>
    </body>

</html>
