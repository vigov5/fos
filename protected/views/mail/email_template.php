<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
    </head>
    <body>
        <div>
            <div style="background-color:  rgb(74, 77, 80); padding: 10px 0px;">
                <div style="width: 100% !important; display: table-cell; vertical-align: middle;">
                    <div>
                        <img width="50" src="<?php echo Yii::app()->params['base_url'].'/images/framgia.png'; ?>">
                    </div>
                    <div style="display: table-cell; vertical-align: middle;">
                        <h2 style="padding-left: 50px; color: white;">The Framgia vOting syStem</h2>
                    </div>
                </div>
            </div>
            <div style="height: 50px;"></div>
            <div>Dear <?php echo $name.','; ?></div><br />
            <?php
                switch ($subject) {
                    case 'Sign Up Link':
                        echo '<div>This is link to sign up:</div>';
                        break;
                    case 'Reset Password':
                        echo '<div>This is link to reset your password:</div>';
                        break;
                }
            ?>
            <div><?php echo $content; ?></div>
            <div style="height: 50px;"></div>
            <div style="text-align: center;
                font-size: 0.8em;
                color: white;
                background-color:rgb(74, 77, 80);
                margin: 0px;
                padding: 10px 0px;">
                    Copyright &copy; <?php echo date('Y'); ?> by Framgia.<br/>
                    All Rights Reserved.<br/>                        
                    <?php echo Yii::powered(); ?>                   
            </div>
        </div>
    </body>
</html>