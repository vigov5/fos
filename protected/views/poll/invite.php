<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/invite_people.js'); ?>
<div class='clear'></div>
<div class='row'>
    <div class='span12'>
        <h3 style='color: red;'>Click the button to invite people</h3> 
    </div>
</div>
<?php
foreach ($users as $usr) {
    echo CHtml::button(
        $usr->username, 
        array(
            'sender_id' => $this->current_user->id,
            'check' => '0',
            'poll_id' => $poll_id,
            'class' => 'btn btn-info btn-check',
            'receiver_id' => $usr->id,
        )
    );
    echo '&nbsp;';
}
?>