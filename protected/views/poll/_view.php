<?php 
/**
 * @var Poll $poll 
 */
?>
<?php
    if ($poll->hasEnded()) {
        $class = 'poll-end';
        $alert = "<span class='poll_note'>This poll has ended at</span> {$poll->end_at}";
    } elseif ($poll->hasStarted()) {
        $class = 'poll-running';
        $alert = "<span class='poll_note'>This poll will end at</span> {$poll->end_at}";
    } else {
        $class = 'poll-notstart';
        $alert = "<span class='poll_note'>This poll will start at</span> {$poll->start_at}";
    }
?>
<div class='row well well-small poll-summary <?php echo $class; ?>' align='left'>
    <?php        
    echo CHtml::link(CHtml::encode($poll->question), array('poll/view', 'id' => $poll->id));
    echo <<< DOC
        <br/>
        <span class='poll_note'>created by</span>
        <span class='user_poll'>{$poll->user->profile->name}</span> 
        <span class='poll_note'>at </span>{$poll->created_at}.
        {$alert}.
DOC;
    ?>
</div>
