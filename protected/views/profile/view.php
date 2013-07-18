<?php
/* @var $this ProfileController */
/* @var $model Profile */
?>

<h1>View <?php echo $profile->name; ?>'s profile</h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $profile,
    'attributes' => array(
        'id',
        'email',
        'name',
        'phone',
        'address',
        'employee_code',
        'secret_key',
        'position',
        'date_of_birth',
        'created_at',
        'updated_at',
    ),
));
?>
