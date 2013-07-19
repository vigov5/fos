<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div class="center_form">
    <div class="row text-center">
        <h1>Password Recovery</h1>
    </div>
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
    <div>
        <form method="Post">
            <div class="span7">           
                <div style="height:40px"></div>
                <div>
                    <label class="" >
                    <?php echo CHtml::textField('ForgetPasswordForm[arg]', null, array(
                        'class' => 'span25 offset4', 
                        'placeholder' => 'Username or Email or Employee code')); ?>
                    </label>
                </div>
                <div style="height:30px"></div>
                <div class="row">
                    <?php
                        echo CHtml::button('Submit', array(
                                'submit' => array('user/forgetPassword'),
                                'class' => 'btn btn-primary btn-medium span5 offset7',)
                            );
                    ?>
                </div>
            </div>
        </form>
    </div>
    <div style="height:150px"></div>
</div>