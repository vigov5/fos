<script src='<?php echo Yii::app()->baseUrl; ?>/js/datetime_picker.js'></script> 
<script src='<?php echo Yii::app()->baseUrl; ?>/js/create_poll.js'></script>
<script src='<?php echo Yii::app()->baseUrl; ?>/js/poll_index.js'></script> 
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
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($poll); ?>
 
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll, 'is_multichoice'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php
            echo CHtml::activeDropDownList(
                $poll, 'is_multichoice', 
                array_flip(Poll::$IS_MULTICHOICES_SETTINGS),
                array(
                    'id' => 'select_multichoice', 
                    'class' => 'select_option',
                    'disabled' => !($poll->isNewRecord),
                )
            );
            ?>
            <?php echo '</div>'; ?>
        </div>
          
    </div>    
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll, 'poll_type'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php echo CHtml::activeDropDownList(
                $poll,
                'poll_type',
                array_flip(Poll::$POLL_TYPE_SETTINGS),
                array(
                    'id' => 'poll_type', 
                    'class' => 'select_option',
                    'disabled' => !($poll->isNewRecord),
                )
            ); ?>
            <?php echo '</div>'; ?>
        </div>

    </div>
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll,'display_type'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php echo CHtml::activeDropDownList(
                $poll,
                    'display_type',
                array_flip(Poll::$POLL_DISPLAY_SETTINGS),
                array(
                    'id' => 'display_type', 
                    'class' => 'select_option',
                    'disabled' => !($poll->isNewRecord),
                )
            ); ?>
            <?php echo '</div>'; ?>
        </div>        
    </div>
    
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll,'result_display_type'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php echo CHtml::activeDropDownList(
                $poll,
                'result_display_type',
                array_flip(Poll::$RESULT_DISPLAY_SETTINGS),
                array('id' => 'result_display_type', 'class' => 'select_option')
            ); ?>
            <?php echo '</div>'; ?>
        </div>
        
    </div>
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll,'result_detail_type'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php echo CHtml::activeDropDownList(
                $poll,
                'result_detail_type',
                array_flip(Poll::$RESULT_DETAIL_SETTINGS),
                $poll->poll_type == '1' ?  array('disabled' => 'true') : array('id' => 'result_detail_type', 'class' => 'select_option')
            ); ?>
            <?php echo '</div>'; ?>
        </div>
        
    </div>
    
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($poll,'result_show_time_type'); ?>
            <?php echo '<div class="wide picker">'; ?>
            <?php echo CHtml::activeDropDownList(
                $poll,
                'result_show_time_type',
                array_flip(Poll::$RESULT_TIME_SETTINGS),
                array('id' => 'result_show_time_type', 'class' => 'select_option')
            ); ?>
            <?php echo '</div>'; ?>
        </div>
        
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
            <?php echo $form->labelEx($poll,'start_at'); ?>
            <?php echo $form->textField($poll,'start_at',array(
                'class' => 'text input',
                'placeholder' => 'From',
                'id' => 'start_at',
            )); ?>        
        </div>
        <div class="span4">
            <?php echo $form->labelEx($poll,'end_at'); ?>
            <?php echo $form->textField($poll,'end_at',array(
                'class' => 'text input',
                'placeholder' => 'To',
                'id' => 'end_at',
             )); ?>        
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