<div style="height:50px"></div>
<h1 class="page-title">Sign Up</h1>
<form method='post'> 
    <?php echo CHtml::errorSummary($form); ?> 
    <div class="">
        <div class="">
            <?php echo CHtml::activeTextField($form, 'username', array('class' => '', 'placeholder' => 'Username')); ?>
        </div>
    </div> 
    <div class="">
        <div class="">
            <?php echo CHtml::activePasswordField($form, 'password', array('class' => '', 'placeholder' => 'Password')); ?>
        </div>
    </div>
    <div class="">
        <div class="">
            <?php echo CHtml::activePasswordField($form, 'passwordConfirm', array('class' => '', 'placeholder' => 'Password Confirmation')); ?>
        </div>
    </div>
    <div style="height:20px"></div>          
    <div class=""><?php echo CHtml::submitButton('Sign in'); ?></div>
</form>