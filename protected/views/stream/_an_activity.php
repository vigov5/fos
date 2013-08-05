<?php // 
/*
 * An template used for displaying an activity at stream
 * @author Tran Duc Thang
 * @var array $activity
 */
?>
<div class="alert stream-item">
    <?php
        $text_view = mb_strimwidth($activity->poll->question, 0, 50, "...");
        $poll = $activity->poll->createViewLink($text_view);
        $user = $activity->user->profile->createViewLink();
        switch ($activity->type) {
            case Activity::CREATE_POLL;
                echo "{$user} created poll {$poll}.";
                break;
            case Activity::ADD_CHOICE;                
                echo "{$user} added choice <b>{$activity->choice->content}</b> for poll {$poll}.";
                break;
            case Activity::CHANGE_POLL_TIME;
                echo "{$user} changed time settings of poll {$poll}.";
                break;
            case Activity::CHANGE_POLL_SETTING;
                echo "{$user} changed settings of poll {$poll}.";
                break;
            case Activity::VOTE;                
                echo "{$user} voted in poll {$poll} with <b>{$activity->choice->content}.</b>";
                break;
            case Activity::RE_VOTE;                
                echo "{$user} re-voted in poll {$poll} with <b>{$activity->choice->content}.</b>";
                break;
            case Activity::INVITE;
                $target_user = $activity->target_user->profile->createViewLink();
                echo "{$user} invited {$target_user} to vote in poll {$poll}";
                break;
            case Activity::COMMENT;
                echo "{$user} commented in poll {$poll}";
                break;
            case Activity::REPLY_COMMENT;
                echo "{$user} replied a comment in poll {$poll}";
                break;
            default:
                break;
        }
    ?>
</div>
