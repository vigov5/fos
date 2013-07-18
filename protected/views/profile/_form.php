<?php
/* @var $this ProfileController */
/* @var $profile Profile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'profile-form',
        'type' => 'horizontal',
        'enableAjaxValidation' => false,
    ));
?>
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($profile); ?>
    <?php echo $form->textFieldRow($profile, 'email', array('class' => 'span4')); ?>
    <?php echo $form->textFieldRow($profile, 'name',array('class' => 'span4')); ?>
    <?php echo $form->textAreaRow($profile, 'address',array('class' => 'span4', 'rows' => 3)); ?>
    <?php echo $form->textFieldRow($profile, 'employee_code',array('class' => 'span4')); ?>
    <?php echo $form->textFieldRow($profile, 'position',array('class' => 'span2')); ?>
    <?php echo $form->textFieldRow($profile, 'date_of_birth', array(
            'class' => 'span2',
            'hint' => 'Format is Year-Month-Day. Example: 1991-11-27',
        ));
    ?>
    <div class="form-actions">
        <?php
            echo CHtml::submitButton($profile->isNewRecord ? 'Create' : 'Save',
                    array('class' => 'btn btn-primary')
                );
        ?>
        <?php echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->