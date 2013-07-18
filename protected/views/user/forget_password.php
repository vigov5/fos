<div style="height:50px"></div>
<div>
    <div>
        <h1>Password Recovery</h1>
    </div>
</div>

<div>
    <form method="Post">
        <div>           
            <div style="height:50px"></div>
            <div>
                <?php echo CHtml::textField('ForgetPasswordForm[arg]', null, array('class' => '', 
                    'placeholder' => 'Username or Email or Employee code')); ?>
            </div>
            <div style="height:50px"></div>
            <div><?php echo CHtml::submitButton('Submit'); ?></div>
        </div>
    </form>
</div>
<div style="height:150px"></div>