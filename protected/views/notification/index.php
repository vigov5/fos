<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/notification.js');
?>
<h1>Your Notifications</h1>
<div id="notification-list"></div>
<div class="end_activity">
<?php
echo CHtml::button('Load more', array('class' => 'btn btn-primary', 'id' => 'load_more_btn'));
?>
</div>