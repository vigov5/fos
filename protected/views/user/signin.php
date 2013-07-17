<div style="height:70px"></div>
<h1> Sign In</h1>
<?php
$this->breadcrumbs = array(
    'User' => array('signin'),
    'Log in',
);
?>

<form method='post'>
    <?php echo CHtml::errorSummary($form); ?>
    <div class="">
        <?php echo CHtml::activeTextField($form, 'username', array('class' => '', 'placeholder' => 'Username')); ?>
    </div>
    <div class="">
        <?php echo CHtml::activePasswordField($form, 'password', array('class' => '', 'placeholder' => 'Password')); ?>
    </div>
    <div style="height:20px"></div>
    <div class="" style="color: blue; font-size: 8px">
        <label>
            <input name='SignInForm[rememberMe]' type="checkbox">
            Log in automatically
        </label>
    </div>
    <div class=""><?php echo CHtml::link('Forget your password ?', array('user/forgetPassword')); ?></div>
    <div style="height:20px"></div>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit','type' => 'primary', 'label'=>'Sign in')); ?>

</form>