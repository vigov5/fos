<div class='span1' align='center'>
    <?php
    echo "<span class='poll_note'>#{$data->id}</span>" . CHtml::image(Yii::app()->baseUrl . '/images/thread.gif', null, array('width' => '30'));
    ?>
</div>
<div class='span9' align='left'>
    <?php
    echo CHtml::link(CHtml::encode($data->question), array('poll/view', 'id' => $data->id));
    echo "<br/><span class='poll_note'>created by</span>
         <span class='user_poll'>{$data->user->username}</span> 
         <span class='poll_note'> at </span>{$data->created_at}";
    ?>
</div>
