<?php

/*
 * An template used for displaying an activity at stream
 * @author Tran Duc Thang
 * @var array $activity
 */
?>
<div class="alert alert-success stream-item">
    <?php            
        switch ($activity->type) {
            case Activity::CREATE_POLL;
                echo $activity->user->profile->createViewLink();
                echo ' created ';
                echo $activity->poll->createViewLink();
                break;
            case Activity::ADD_CHOICE;
                echo $activity->user->profile->createViewLink();
                echo ' added choices for';
                echo $activity->poll->createViewLink();
                break;
            case Activity::CHANGE_POLL_TIME;
                echo $activity->user->profile->createViewLink();
                echo ' changed ';
                echo $activity->poll->createViewLink();
                echo ' time';
                break;
            case Activity::CHANGE_POLL_SETTING;
                echo $activity->user->profile->createViewLink();
                echo ' changed ';
                echo $activity->poll->createViewLink();
                echo ' setting';
                break;
            case Activity::VOTE;
                echo $activity->user->profile->createViewLink();
                echo ' voted in ';
                echo $activity->poll->createViewLink();
                break;
            case Activity::RE_VOTE;
                echo $activity->user->profile->createViewLink();
                echo ' revoted ';
                echo $activity->poll->createViewLink();
                break;
            case Activity::INVITE;
                echo $activity->user->profile->createViewLink();
                echo 'invited in';
                echo $activity->poll->createViewLink();
                break;
            case Activity::COMMENT;
                echo $activity->user->profile->createViewLink();
                echo 'commented in ';
                echo $activity->poll->createViewLink();
                break;
            case Activity::REPLY_COMMENT;
                echo $activity->user->profile->createViewLink();
                echo ' replied a comment in ';
                echo $activity->poll->createViewLink();
                break;
            
            default:
                break;
        }
    ?>
</div>
