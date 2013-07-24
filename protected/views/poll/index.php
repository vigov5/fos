<script src='<?php echo Yii::app()->baseUrl; ?>/js/poll_index.js'></script> 
<div class='clear'></div>
<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
    'links' => array(
        'Home' => array('home/index'),
    ),
    'links' => array(
        'Poll' => array('poll/index'),
    ),
));
?>
<?php
    $this->widget('bootstrap.widgets.TbAlert');
?>

<div class='row'>
    <div class='span6'>
        <h2><?php echo $title; ?></h2>
    </div>
    <div class='span2'>
        <br/>
        <?php
        echo CHtml::button('Create Poll', array(
            'submit' => array('poll/create'),
            'class' => 'btn btn-success'
        ));
        ?>
    </div>
    <div class='span2'>
        <br/>
        <?php
        echo CHtml::button('Show Search ', array('id' => 'show_search', 'class' => 'btn btn-primary'));
        ?>
    </div>
</div>

<?php echo CHtml::beginForm('', 'get', array('id' => 'form_search', 'hidden' => 'hidden')); ?>
<div>
    <ul>
        <li>
            <div class="xxwide picker">
                <?php
                echo CHtml::dropDownList('status', $status, array('is_multichoice' => 'Is Multichoice') 
                    + array_flip(Poll::$IS_MULTICHOICES_SETTINGS));
                echo '</span>&nbsp';
                echo CHtml::dropDownList('poll_type', $poll_type, array('poll_type' => 'Poll Type')
                    + array_flip(Poll::$POLL_TYPE_SETTINGS));
                ?>
            </div>
            <div class="xxwide picker">
                <?php
                echo CHtml::dropDownList('display_type', $display_type, array('display_type' => 'Display Type')
                    + array_flip(Poll::$POLL_DISPLAY_SETTINGS));
                echo '</span>&nbsp';
                echo CHtml::dropDownList('result_display_type', $result_display_type, array('result_display_type' => 'Result Display Type')
                    + array_flip(Poll::$RESULT_DISPLAY_SETTINGS));
                ?>
            </div>
            <div class="xxwide picker">
                <?php
                echo CHtml::dropDownList('result_detail_type', $result_detail_type, array('result_detail_type' => 'Result Detail Type')
                    + array_flip(Poll::$RESULT_DETAIL_SETTINGS));
                echo '</span>&nbsp';
                echo CHtml::dropDownList('result_show_time_type', $result_show_time_type, 
                    array('result_show_time_type' => 'Result Show Time Type') + array_flip(Poll::$RESULT_TIME_SETTINGS));
                ?>
            </div>
        </li>
    </ul>
</div>
<div class="medium primary btn two columns">
    <?php echo CHtml::submitButton('Search', array('id' => 'search-button')); ?>
</div>
<?php echo CHtml::endForm(); ?>
<hr style="color: #808080">
<?php
foreach ($polls as $poll) {
    echo "<div class='row'>";
    $this->renderPartial('_view', array('poll' => $poll));
    echo "</div>";
}
?>