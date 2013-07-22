<?php
/* @var $this ChoiceController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="container">
    <div class="media">
        <div class="media-body">
            <h4 class="media-heading"><?php echo $poll->question; ?></h4>
            <?php echo $poll->description; ?>
            
            <?php
                foreach ($choices as $choice)
                {
                    echo '<div class="well well-small">';
                    echo $choice->content;
                    echo '</div>';
                }
            ?>
            <?php echo CHtml::beginForm(array('choice/create'), 'post', array('class' => 'well form-inline')); ?>
            <?php echo CHtml::textField('choice_name','',array('placeholder' => 'Add choice', 'class' => 'input-lager')); ?>
            <?php echo CHtml::submitButton('Add', array('class' => 'btn', 'id' => 'add_choice')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
    