<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<?php if ($code == 404) {
    echo "<h2> Sorry ! This page not present. </h2>";
    echo CHtml::image(Yii::app()->baseUrl.'/images/1.gif', null, array('class' => 'not_found_image'));
}  else {
    echo "<h2>Error {$code}</h2>";
    echo '<div class="error">';
    echo CHtml::encode($message);
    echo '</div>';
}
?>