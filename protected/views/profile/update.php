<?php
/* @var $this ProfileController */
/* @var $profile Profile */
?>
<legend>
    <h1>Update Profile <?php echo $profile->employee_code; ?></h1>
</legend>
<?php echo $this->renderPartial('_form', array('profile' => $profile)); ?>