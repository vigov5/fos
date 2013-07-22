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
<div class='row'>
    <div class='span10'>
        <h2> All polls</h2>
    </div>
    <div class='span2'>
        <?php
        echo CHtml::button('Create Poll', array(
            'submit' => array('poll/create'),
            'class' => 'btn btn-success'
            ));
        ?>
    </div>
</div>
<hr style="color: #808080">
<div class='row' >
    <div class='span1' align='center'>
        <span style='color: blue; font-size: 16px; font-weight: bold;'>ID</span>
    </div>
    <div class='span9'>
        <span style='color: blue; font-size: 16px; font-weight: bold;'>Question</span>
    </div>
</div>
<?php
foreach ($polls as $poll) {
    echo "<div class='row'>";
    $this->renderPartial('_view', array('data' => $poll));
    echo "</div>";
}
?>