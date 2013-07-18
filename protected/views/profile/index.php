<?php
/* @var $this ProfileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Profiles',
);
?>

<div class="row">
    <h2>Profiles</h2>
    <?php if (Yii::app()->user->isAdmin) { ?>
        <div>
            <?php echo CHtml::button('Create profile', array('submit' => array('profile/create'),
                'class' => 'btn btn-primary')); ?>
        </div>
    <?php } ?>

    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
    <HR>
    <?php
    for ($i = 0; $i < sizeof($profiles); $i += 2) {
        echo '<div class="row-fluid">';
        echo '<div class="span6">';
        $this->renderPartial('_view', array('data' => $profiles[$i]));
        echo '</div>';
        echo '<div class="span6">';
        if (isset($profiles[$i+1])){
            $this->renderPartial('_view', array('data' => $profiles[$i+1]));
        }
        echo '</div></div>';
        echo '</br>';
    };
    ?>
</div>
<div class="row">
    <?php $this->widget('CLinkPager', array(
        'pages' => $pages,
    )); ?>
</div>