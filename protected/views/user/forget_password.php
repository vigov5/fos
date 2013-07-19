<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<div class="none"></div>
<div class="row">
    <div class="span10">
        <h1 class="page-title">Password Recovery</h1>
    </div>
</div>

<div class="row">
    <form method="Post">
        <div class="span7">           
            <div style="height:50px"></div>
            <?php if (Yii::app()->user->hasFlash('success','')): ?>
                <div class="success alert">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="danger alert">
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <div class="field">
                <?php echo CHtml::textField('ForgetPasswordForm[arg]', null, array('class' => 'text input',
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