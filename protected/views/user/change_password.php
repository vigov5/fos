<div style="height:50px"></div>
<div>
    <div>
        <h1>Change Password</h1>
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
                    <?php echo CHtml::activePasswordField($form, 'oldPass', array('class' => '', 
                        'placeholder' => 'Old Password')); ?>
                </div>
            </div>
            <div>
                <div>                
                    <?php echo CHtml::activePasswordField($form, 'newPass', array('class' => '', 
                        'placeholder' => 'New Password')); ?>
                </div>
            </div>
            <div>
                <div>            
                    <?php echo CHtml::activePasswordField($form, 'passConfirm', array('class' => '', 
                        'placeholder' => 'New Password Confirmation')); ?>
                </div>
            </div>
            <div style="height:50px"></div>            
            <div><?php echo CHtml::submitButton('Submit'); ?></div>                            
        </div>
    </form>
</div>
<div style="height:50px"></div>
