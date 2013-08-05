<?php

?>
<div class="comment comment_container" id="comment_container_<?php echo $comment->id ?>">
    <div class="comment_content" id="comment_content_<?php echo $comment->id ?>">
        <div class="row user_comment">
            <?php echo $comment->user->profile->createViewLink(); ?>
        </div>
        <div class="row">
            <?php echo $comment->content ?> <br>
        </div>
        <div class="row">
            <div class="time_update">
                <?php echo $comment->updated_at ?>
            </div>
            <?php
            echo CHtml::button(
                    'Reply',
                    array(
                        'class' => 'reply_comment btn btn-primary btn-mini',
                        'data-comment_id' => $comment->id
                    )
            );
            echo " ";
            if (count($comment->children) > 0) {
                echo CHtml::button(
                    'Load replies (' . count($comment->children) .')',
                    array(
                        'class' => 'load_children_comment btn btn-info btn-mini',
                        'data-comment_id' => $comment->id
                    )
                );
            }
            ?>
        </div>
    </div>
</div>
<div class="children_comments" id="children_comments_<?php echo $comment->id ?>">
</div>
