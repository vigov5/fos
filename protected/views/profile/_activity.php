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
    $time = ' at <i>' . DateAndTime::humanReadableTime($activity->created_at) . '</i>';
    if (isset($activity->choice)) {
        $choice_content = "<b>{$activity->choice->content}</b>";
    } else {
        $choice_content = '';
    }
    if ($profile->user->id === $this->current_user->id) {
        $name = 'You';
    } else {
        $name = $profile->createViewLink();
    }
    switch ($activity->type) {
        case Activity::CREATE_POLL;
            echo "{$name} created {$view_poll} {$time}";
            break;
        case Activity::ADD_CHOICE;
            echo "{$name} added choices {$choice_content} for {$view_poll} {$time}";
            break;
        case Activity::CHANGE_POLL_TIME;
            echo "{$name} changed {$view_poll} time {$time}";
            break;
        case Activity::CHANGE_POLL_SETTING;
            echo "{$name} changed {$view_poll} setting {$time}";
            break;
        case Activity::VOTE;
            echo "{$name} voted for {$choice_content} in {$view_poll} {$time}";
            break;
        case Activity::RE_VOTE;
            echo "{$name} revoted for {$choice_content} in {$view_poll} {$time}";
            break;
        case Activity::INVITE;
            echo "{$name} invited in {$view_poll} {$time}";
            break;
        case Activity::COMMENT;
            echo "{$name} commented in {$view_poll} {$time}";
            break;
        case Activity::REPLY_COMMENT;
            echo "{$name} replied a comment in {$view_poll} {$time}";
            break;
        default:
            break;
    }
    ?>
</div>

