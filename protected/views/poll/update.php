<div class="row">

<h2>Update Poll <span style='color: red;'><?php echo "{$poll->question}(id={$poll->id})"; ?></span></h2>
<?php echo $this->renderPartial('_form', array('poll'=>$poll)); ?>

</div>