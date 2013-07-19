<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div class="center_form">
    <div class="row text-center">
        <h1>Change Password</h1>
    </div>
    <form method="Post">      
        <div>
            <div style="height:50px"></div>
            <?php echo CHtml::errorSummary($form); ?>      
            <div class="row">            
                <?php echo CHtml::activePasswordField($form, 'oldPass', array(
                        'class' => 'span6 offset3', 
                        'placeholder' => 'Old Password',
                    ));
                ?>
            </div>
            <div class="row">           
                <?php echo CHtml::activePasswordField($form, 'newPass', array(
                        'class' => 'span6 offset3', 
                        'placeholder' => 'New Password',
                    ));
                ?>
            </div>
            <div class="row">        
                <?php echo CHtml::activePasswordField($form, 'passConfirm', array(
                    'class' => 'span6 offset3', 
                    'placeholder' => 'New Password Confirmation',
                    ));
                ?>
            </div>
            <div class="none"></div>            
            <div class="row"><?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary span2 offset5')); ?></div>                            
        </div>
    </form>
</div>
<div style="height:50px"></div>
