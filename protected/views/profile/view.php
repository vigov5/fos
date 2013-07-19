<?php
/* @var $this ProfileController */
/* @var $model Profile */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<h1><?php echo $profile->name; ?>'s profile</h1>

<?php
    if (Yii::app()->user->is_admin) {
        echo CHtml::link('Edit this profile',
            array('profile/update', 'id' => $profile->id),
            array('class' => 'btn btn-primary')
        );
    }
?>
<div class="none"></div>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $profile,
    'attributes' => array(
        'email',
        'name',
        'phone',
        'address',
        'employee_code',
        'position',
        'date_of_birth',
    ),
));
?>
