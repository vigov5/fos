<div class='row'>
    <div class='span6'><h3>Update Poll</h3></div>
</div>
<br/>
<div class="row">
<?php
    echo $this->renderPartial(
        '_form',
        array(
            'poll' => $poll,
            'voting' => $voting,
            'voted' => $voted,
        )
    ); 
?>

</div>