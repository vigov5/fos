<div class="none"></div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div id="activity">
    <?php

    foreach ($activities as $activity) {
        $this->renderPartial('_activity', array('activity' => $activity));
    }
    ?>
</div>
<?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#activity',
    'itemSelector' => 'div.content-item',
    'loadingText' => 'Loading...',
    'donetext' => 'This is the end...',
    'pages' => $pages,
)); ?>