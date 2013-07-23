<?php
/* @var $this ChoiceController */
/* @var $dataProvider CActiveDataProvider */

?>
<script src='<?php echo Yii::app()->baseUrl; ?>/js/add_choice.js'></script>
<div class="container">
    <div class="media">
        <div class="media-body">
            
            <h4 class="media-heading"><?php echo $poll->question; ?></h4>
            <?php echo $poll->description; ?>
            <div id="choice_content">
                <?php
                    foreach ($choices as $choice)
                    {
                        echo '<div class="well well-small">';
                        echo $choice->content;
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="well form-inline">
                <?php echo CHtml::textField('choice_name', '', array('placeholder' => 'Add choice',
                    'class' => 'input-lager', 'id' => 'add_choice_textfield', 'data-poll_id' => $poll->id)); ?>
                <?php echo CHtml::Button('Add', array('class' => 'btn', 'id' => 'add_choice')); ?>
            </div>
        </div>
    </div>
</div>
    