<?php

?>
<div class="comment comment_container" id="comment_container_<?php echo $comment->id ?>">
    <div class="comment_content" id="comment_content_<?php echo $comment->id ?>">
        <div class="user_comment">
            <?php echo $comment->user->profile->createViewLink(); ?>
        </div>
        <?php echo $comment->content ?> <br>
        <div class="time_update">
            <?php echo $comment->updated_at ?>
        </div>
        <?php
        echo CHtml::link('Reply (' . count($comment->children). ')', '',
            array('class' => 'reply_comment', 'data-comment_id' => $comment->id)
        );
        ?>
    </div>
</div>
<div class="children_comments" id="children_comments_<?php echo $comment->id ?>">
</div>
