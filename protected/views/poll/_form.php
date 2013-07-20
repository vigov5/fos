<script src='<?php echo Yii::app()->baseUrl; ?>/js/create_poll.js'></script> 
<?php
/* @var $this PollController */
/* @var $poll Poll */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poll-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
    <div class="row">
        <div class="span4">
                <?php echo $form->labelEx($poll,'poll_type'); ?>
                <?php echo '<div class="wide picker">'; ?>
                <?php echo CHtml::activeDropDownList($poll,'poll_type', array(0 => 'Non-anonymous',
                 1 => 'Anonymous'), array('id' => 'poll_type')); ?>
                <?php echo '</div>'; ?>
        </div>
     <div class="span4" id="poll_type_content">Owner can view and public voter name !</div>  
    </div>
    
    <div class="row">
        <div class="span4">
                <?php echo $form->labelEx($poll,'display_type'); ?>
                <?php echo '<div class="wide picker">'; ?>
                <?php echo CHtml::activeDropDownList($poll,'display_type', array(0 => 'Public',
                 1 => 'Restricted', 2 => 'Invited Only'), array('id' => 'display_type')); ?>
                <?php echo '</div>'; ?>
        </div>
     <div class="span4" id="display_type_content">All user can see and all user can vote !</div>  
    </div>
    
    <div class="row">
        <div class="span4">
                <?php echo $form->labelEx($poll,'result_display_type'); ?>
                <?php echo '<div class="wide picker">'; ?>
                <?php echo CHtml::activeDropDownList($poll,'result_display_type', array(0 => 'Public',
                 1 => 'Voted Only', 2 => 'Owner Only'), array('id' => 'result_display_type')); ?>
                <?php echo '</div>'; ?>
        </div>
     <div class="span4" id="result_display_type_content">All user who can access can see result !</div>  
    </div>
    
    <div class="row">
        <div class="span4">
                <?php echo $form->labelEx($poll,'result_detail_type'); ?>
                <?php echo '<div class="wide picker">'; ?>
                <?php echo CHtml::activeDropDownList($poll,'result_detail_type', array(0 => 'All',
                 1 => 'Only Percentage'), array('id' => 'result_detail_type')); ?>
                <?php echo '</div>'; ?>
        </div>
     <div class="span4" id="result_detail_type_content">All result include who voted !</div>  
    </div>
    
    <div class="row">
        <div class="span4">
                <?php echo $form->labelEx($poll,'result_show_time_type'); ?>
                <?php echo '<div class="wide picker">'; ?>
                <?php echo CHtml::activeDropDownList($poll,'result_show_time_type', array(0 => 'After',
                 1 => 'During'), array('id' => 'result_show_time_type')); ?>
                <?php echo '</div>'; ?>
        </div>
     <div class="span4" id="result_show_time_type_content">Show result only after poll expired !</div>  
    </div>
    
    <div class="none"></div>
    
    <div class="row">
            <div class="field">
                <?php echo $form->labelEx($poll,'question'); ?>
                <?php echo $form->textArea($poll,'question',array('class' => 'span8', 'rows' => 3,
                    'placeholder' => 'Question')); ?>
            </div>
    </div>
    
    <div class="row">
            <div class="field">
                <?php echo $form->labelEx($poll,'description'); ?>
                <?php echo $form->textArea($poll,'description',array('class' => 'span8', 'rows' => 8,
                    'placeholder' => 'Description')); ?>
            </div>
    </div>
    
    <div class="row">
        <div class="span4"> 
            <?php echo $form->textField($poll,'start_at',array('class' => 'text input', 'placeholder' => 'From')); ?>        
        </div>
        <div class="span4"> 
            <?php echo $form->textField($poll,'end_at',array('class' => 'text input', 'placeholder' => 'To')); ?>        
        </div>
    </div>
    <div class="form-actions">
        <?php
            echo CHtml::submitButton($poll->isNewRecord ? 'Create' : 'Save',
                    array('class' => 'btn btn-primary')
                );
        ?>
        <?php echo CHtml::resetButton('Reset', array('class' => 'btn')); ?>
    </div>
    
<?php $this->endWidget(); ?>
</div>