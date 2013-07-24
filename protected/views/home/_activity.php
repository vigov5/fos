<?php
/*
 * An template used for displaying an activity at stream
 * @author Nguyen Trung Quan
 * @var array $activity
 */
?>
<div class="alert content-item">
    <?php
    $view_poll = $activity->poll->createViewLink();
    $time = " at <i>{$activity->created_at}</i>";
    switch ($activity->type) {
        case Activity::CREATE_POLL;
            echo "You created {$view_poll} {$time}";
            break;
        case Activity::ADD_CHOICE;
            echo "You added choices for {$view_poll} {$time}";
            break;
        case Activity::CHANGE_POLL_TIME;
            echo "You changed {$view_poll} time {$time}";
            break;
        case Activity::CHANGE_POLL_SETTING;
            echo "You changed {$view_poll} setting {$time}";
            break;
        case Activity::VOTE;
            echo "You voted in {$view_poll} {$time}";
            break;
        case Activity::RE_VOTE;
            echo "You revoted {$view_poll} {$time}";
            break;
        case Activity::INVITE;
            echo "You invited in {$view_poll} {$time}";
            break;
        case Activity::COMMENT;
            echo "You commented in {$view_poll} {$time}";
            break;
        case Activity::REPLY_COMMENT;
            echo "You replied a comment in {$view_poll} {$time}";
            break;
        default:
            break;
    }
    ?>
</div>

