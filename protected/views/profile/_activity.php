<?php
/*
 * An template used for displaying an activity at stream
 * @author Nguyen Trung Quan
 * @var array $activity
 */
?>
<div class="alert content-item">
    <?php
    $view_poll = "<b>{$activity->poll->createViewLink()}</b>";
    $time = ' <i>' . DateAndTime::humanReadableTime($activity->created_at) . '</i>';
    if (isset($activity->choice)) {
        $choice_content = "<b>{$activity->poll->createViewLink($activity->choice->content)}</b>";
    } else {
        $choice_content = '';
    }
    if ($profile->user->id === $this->current_user->id) {
        $name = '<b>You</b>';
    } else {
        $name = "<b>{$profile->createViewLink()}</b>";
    }
    switch ($activity->type) {
        case Activity::CREATE_POLL;
            echo "{$name} created poll {$view_poll} {$time}";
            break;
        case Activity::ADD_CHOICE;
            echo "{$name} added choice {$choice_content} for poll {$view_poll} {$time}";
            break;
        case Activity::CHANGE_POLL_TIME;
            echo "{$name} changed {$view_poll} time {$time}";
            break;
        case Activity::CHANGE_POLL_SETTING;
            echo "{$name} changed {$view_poll} setting {$time}";
            break;
        case Activity::VOTE;
            echo "{$name} voted for {$choice_content} in poll {$view_poll} {$time}";
            break;
        case Activity::RE_VOTE;
            echo "{$name} revoted for {$choice_content} in poll {$view_poll} {$time}";
            break;
        case Activity::INVITE;
            echo "{$name} invited <b>{$activity->target_user->profile->createViewLink()}</b> in poll {$view_poll} {$time}";
            break;
        case Activity::COMMENT;
            echo "{$name} commented in poll {$view_poll} {$time}";
            break;
        case Activity::REPLY_COMMENT;
            echo "{$name} replied a comment in poll {$view_poll} {$time}";
            break;
        default:
            break;
    }
    ?>
</div>

