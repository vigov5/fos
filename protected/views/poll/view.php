<h1>Poll Detail </h1>
<div style='height:50px;'></div>
<?php
$this->widget('bootstrap.widgets.TbAlert');
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
                <b> Multichoice :</b>
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
        <?php
        foreach ($choices as $c) {
            echo '<tr>';
            echo '<th>';
            echo '</th>';
            echo '<td>';
            echo $c->content;
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>    
</table>

<table>
<?php
foreach ($comments as $m) {
    $u = $m->user;
}
?>
</table>


