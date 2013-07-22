<h2>All polls</h2>
<div class='row' >
    <div class='span1' align='center'>
        <span style='color: blue; font-size: 16px; font-weight: bold;'>ID</span>
    </div>
    <div class='spa11' align='center'>
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