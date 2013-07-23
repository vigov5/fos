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
                    if ($poll->id === Yii::app()->user->id) {
                        foreach ($choices as $choice)
                        {
                            echo "<div class='well well-small' data-choice_id={$choice->id}>";
                            echo $choice->content;
                            echo "<button class='close close_choice' data-choice_id={$choice->id}>&times;</button>";
                            echo '</div>';
                        }
                    } else {
                        foreach ($choices as $choice)
                        {
                            echo "<div class='well well-small' data-choice_id={$choice->id}>";
                            echo $choice->content;
                            echo '</div>';
                        }
                    }
                    
                ?>
            </div>
            <?php
                if ($poll->user_id === Yii::app()->user->id) {
                    echo '<div class="well form-inline">';
                    echo CHtml::textField('choice_name', '', array('placeholder' => 'Add choice',
                    'class' => 'input-lager', 'id' => 'add_choice_textfield', 'data-poll_id' => $poll->id));
                    echo CHtml::Button('Add', array('class' => 'btn', 'id' => 'add_choice'));
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</div>
    