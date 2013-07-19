<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div class="none"></div>
<div class="row">
    <div class="span10">
        <h1 class="page-title">Password Recovery</h1>
    </div>
</div>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div>
    <form method="Post">
        <div class="span7">           
            <div style="height:50px"></div>
            <div>
                <?php echo CHtml::textField('ForgetPasswordForm[arg]', null, array('class' => '', 
                    'placeholder' => 'Username or Email or Employee code')); ?>
            </div>
            <div style="height:50px"></div>
            <?php
                echo CHtml::button('Submit', array(
                        'submit' => array('user/forgetPassword'),
                        'class' => 'btn btn-primary btn-large',)
                    );
            ?>
        </div>
    </form>
</div>
<div style="height:150px"></div>