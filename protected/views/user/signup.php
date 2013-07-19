<div class="center_form">
    <h1 class="page-title row text-center">Sign Up</h1>
    <div style="height:50px"></div>
    <form method='post'>
        <?php echo CHtml::errorSummary($form); ?>
        <div class="row">
            <?php echo CHtml::activeTextField($form, 'username', array('class' => 'span6 offset3', 'placeholder' => 'Username')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activePasswordField($form, 'password', array('class' => 'span6 offset3', 'placeholder' => 'Password')); ?>
        </div>
        <div class="row">
            <?php echo CHtml::activePasswordField($form, 'passwordConfirm', array('class' => 'span6 offset3', 'placeholder' => 'Password Confirmation')); ?>
        </div>
        <div style="height:20px"></div>
        <div class="row"><?php echo CHtml::submitButton('Sign Up', array('class' => 'span2 offset5')); ?></div>
    </form>
</div>
