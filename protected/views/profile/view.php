<?php
/* @var $this ProfileController */
/* @var $model Profile */
?>

<h1>View <?php echo $profile->name; ?>'s profile</h1>

<?php
    echo CHtml::link('Edit this profile',
        array('profile/update', 'id' => $profile->id),
        array('class' => 'btn btn-primary')
    );
?>
<div class="none"></div>
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $profile,
    'attributes' => array(
        'id',
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
