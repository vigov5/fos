<h1>Poll Detail </h1>
<div style='height:50px;'></div>
<?php
$this->widget('bootstrap.widgets.TbAlert');
?>
<?php
if (Yii::app()->user->is_admin) {
    echo CHtml::button('Delete Poll', array(
        'class' => 'btn-danger',
        'submit' => array(
            'poll/delete',
            'id' => $poll->id),
            'confirm' => 'Do you want to delete this poll ?')
    );
}
if (Yii::app()->user->is_admin || Yii::app()->user->getId() == $user->id) {
    echo CHtml::button('Edit Poll', array(
        'class' => 'btn-warning',
        'submit' => array(
            'poll/update',
            'id' => $poll->id)
        )
    );
}
?>
<table class='detail-view table table-striped table-condensed' id='yw1'>
    <tbody>
        <tr class='odd'>
            <th>User</th>
            <td><?php echo $user->username ?></td>
        </tr>
        <tr class='even'>
            <th>Setting</th>
            <td>
                <b> Multi-choice :</b>
                <?php
                if ($poll->is_multichoice == POll::IS_MULTICHOICES_NO) {
                    echo ' No ';
                } else {
                    echo ' Yes ';
                }
                ?>
            </td>
        </tr>
        <tr class='even'>
            <th></th>
            <td>
                <b> Poll Type :</b>
                <?php
                if ($poll->poll_type == Poll::POLL_TYPE_SETTINGS_ANONYMOUS) {
                    echo ' Anonymous ';
                } else {
                    echo ' Non-Anonymous ';
                }
                ?>
            </td>
        </tr>
        <tr class='even'>
            <th></th>
            <td>
                <b>Poll Display :</b>
                <?php
                switch ($poll->display_type) {
                    case Poll::POLL_DISPLAY_SETTINGS_PUBLIC:
                        echo ' Public ';
                        break;
                    case Poll::POLL_DISPLAY_SETTINGS_RESTRICTED:
                        echo ' Restricted ';
                        break;
                    default:
                        echo ' Invited Only ';
                        break;
                }
                ?>
            </td>
        </tr>
        <tr class='odd'>
            <th></th>
            <td>
                <b>Result Display :</b>
                <?php
                switch ($poll->result_display_type) {
                    case Poll::RESULT_DISPLAY_SETTINGS_PUBLIC:
                        echo 'Pulic';
                        break;
                    case Poll::RESULT_DISPLAY_SETTINGS_VOTED_ONLY:
                        echo 'Voted Only';
                        break;
                    default:
                        echo 'Owner Only';
                        break;
                }
                ?>
            </td>
        </tr>
        <tr class='even'>
            <th></th>
            <td>
                <b>Result Details :</b>
                <?php
                if ($poll->result_detail_type == Poll::RESULT_DETAIL_SETTINGS_ALL) {
                    echo ' All ';
                } else {
                    echo ' Only Percentage ';
                }
                ?>
            </td>
        </tr>
        <tr class='odd'>
            <th></th>
            <td>
                <b>Result Show Time :</b>
                <?php
                if ($poll->result_show_time_type == Poll::RESULT_TIME_SETTINGS_AFTER) {
                    echo ' After vote finish';
                } else {
                    echo ' During ';
                }
                ?>
            </td>
        </tr>
        <tr class='even'>
            <th>Question</th>
            <td><?php echo $poll->question ?></td>
        </tr>
        <tr class='odd'>
            <th>Description</th>
            <td><?php echo $poll->description ?></td>
        </tr>
        </tbody>
    </table>
    <form method="post" action="<?php echo Yii::app()->createUrl('poll/vote', array('id' => $poll->id));?>">
        <?php
        foreach ($choices as $c) {
            if ($poll->is_multichoice) {
                echo CHtml::checkBox('choice['.$c->id.']', false);
            } else {
                echo CHtml::radioButton('choice', false, array('value' => $c->id));
            }
            echo $c->content;
            echo '<br>';
        }
        if (empty($all_votes)) {
            echo CHtml::submitButton('Vote');
        } else {
            foreach ($all_votes as $vote) {
                echo "You voted with \"{$vote->choice->content}\"<br>";
            }
            echo CHtml::submitButton('Re-Vote');
        }
        ?>
    </form>


<table>
<?php
foreach ($comments as $m) {
    $u = $m->user;
}
?>
</table>
