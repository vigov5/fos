<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <?php
        Yii::app()->bootstrap->register();
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/form.css');
        ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="row-fluid" id="page">
            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            </div><!-- header -->

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
                                'items' => array(
                                    array('label' => 'Home', 'icon' => 'home white', 'url' => array('home/index')),
                                    array('label' => '', 'icon' => 'star', 'url' => '#'),
                                    array('label' => '', 'icon' => 'envelope', 'url' => '#'),
                                    array('label' => '', 'icon' => 'globe', 'url' => '#'),
                                ),
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
                                'items' => array(
                                    array('label' => 'Home', 'icon' => 'home white', 'url' => array('home/index')),
                                    array('label' => '', 'icon' => 'star', 'url' => '#'),
                                    array('label' => '', 'icon' => 'envelope', 'url' => '#'),
                                    array('label' => '', 'icon' => 'globe', 'url' => '#'),
                                ),
                            ),
                            '<form class="navbar-search pull-left" action=""><input type="text"
                             class="search-query" placeholder="search people, post and anythings">
                            </form>',
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'items' => array(
                                    array('label' => Yii::app()->user->username, 'icon' => 'user white', 'url' => '#',
                                        'items' => array(
                                            array('label' => 'Profile', 'icon' => 'pencil', 'url' => '#'),
                                            array('label' => 'Settings', 'icon' => 'cog', 'url' => '#'),
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
            </div><!-- mainmenu -->

            <div class="clear"></div>
            <div class="content">
                <?php echo $content; ?>
            </div>
            <div class="clear"></div>
        </div><!-- page -->
        <div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by Framgia.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </div><!-- footer -->
    </body>
</html>
