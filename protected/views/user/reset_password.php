<div style="height:50px"></div>
<div>
    <div>
        <h1>Reset Password</h1>
    </div>
</div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div>
    <form method="Post">      
        <div>          
            <div style="height:50px"></div>
            <?php echo CHtml::errorSummary($form); ?>      
            <div>
                <div>                
                    <?php echo CHtml::activePasswordField($form, 'password', 
                        array('class' => '', 'placeholder' => 'New Password')); ?>
                </div>
            </div>
            <div>
                <div>            
                    <?php echo CHtml::activePasswordField($form, 'passwordConfirm', 
                        array('class' => '', 'placeholder' => 'New Password Confirmation')); ?>
                </div>
            </div>
            <div style="height:50px"></div>            
            <div class=""><?php echo CHtml::submitButton('Submit'); ?></div>                            
        </div>
    </form>
</div>
<div class="none"></div>
