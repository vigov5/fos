<div class="row">    
    <div class="span6">
        <b><?php echo CHtml::encode($data->getAttributeLabel('employee_code')); ?>:</b>
        <?php echo Chtml::link(CHtml::encode($data->employee_code), array('view', 'id' => $data->id)); ?>
        <br />
        <b><?php echo CHtml::encode('User'); ?>:</b>
            <?php
                if (isset($data->user->username)) {
                    echo CHtml::encode($data->user->username);
                } else {
                    echo CHtml::encode('No user');;
                }
            ?>
        <br />
        <?php
            echo "<b>Emai:</b>{$data->email}";
        ?>
        <br />
        <?php
            if ($data->name != null) {
                echo CHtml::encode($data->getAttributeLabel('name')).': ';
                echo CHtml::encode($data->name).'<br/>';
            }
        ?>
        <?php
            if ($data->phone != null) {
                echo CHtml::encode($data->getAttributeLabel('phone')).': ';
                echo CHtml::encode($data->phone).'<br/>';
            }
        ?>
    </div>
</div>
<div class="row">
    <?php
        if (Yii::app()->user->isAdmin){
            if (empty($data->user->is_admin)) {
                if (isset($data->user->username)) {
                    echo '<span>';
                    echo CHtml::button('Delete user', array('submit' => array('user/delete',
                        'id' => $data->id), 'class' => 'btn btn-warning',
                        'confirm'=>'Do you want to delete this user permanently?'));
                    echo '</span>&nbsp';
                } else {
                    echo '<span>';
                    echo CHtml::button('Send sign up email', array('submit' => array('profile/sendSignUpEmail',
                        'id' => $data->id), 'class' => 'btn btn-info'));
                    echo '</span>&nbsp';
                }
            }
            echo '<span>';
            echo CHtml::button('Update profile', array('submit' => array('profile/update',
                'id' => $data->id), 'class' => 'btn btn-success'));
            echo '</span>&nbsp';
            if (empty($data->user->is_admin)) {
                echo '<span>';
                echo CHtml::button('Delete profile', array('submit' => array('profile/delete',
                    'id' => $data->id),'class' => 'btn btn-danger',
                    'confirm'=>'Do you want to delete this profile permanently?'));
                echo '</span>';             
            }
        }
    ?>
</div>
<?php echo'<br>'; ?>