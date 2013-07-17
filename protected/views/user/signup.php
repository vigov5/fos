

<div style="height:50px"></div>
<h1 class="page-title">Sign Up</h1>
<?php die(); ?>
<form method='post'> 
    <?php echo CHtml::errorSummary($form); ?>    
    <div class="">
        <div class="">
            <?php echo CHtml::activeTextField($form, 'username', array('class' => 'text input', 'placeholder' => 'Username')); ?>
        </div>
    </div> 
    <div class="">
        <div class="">
            <?php echo CHtml::activePasswordField($form, 'password', array('class' => 'password input', 'placeholder' => 'Password')); ?>
        </div>
    </div>
    <div class="">
        <div class="">
            <?php echo CHtml::activePasswordField($form, 'passwordConfirm', array('class' => 'password input', 'placeholder' => 'Password Confirmation')); ?>
        </div>
    </div>
    <div style="height:50px"></div>          
    <div class=""><?php echo CHtml::submitButton('Sign Up'); ?></div>
</form>